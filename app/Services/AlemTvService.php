<?php

namespace App\Services;

use App\Models\PaymentRequest;
use App\Models\User;
use App\Services\Clients\AlemTvClient;
use Illuminate\Support\Facades\Cache;

class AlemTvService
{
    public function __construct(protected AlemTvClient $client) {}

    public function getTarifs(string $type): array
    {
        $cacheKey = "alemtv_tarifs:{$type}";
        $ttl      = 86400;

        return Cache::store('file')->remember($cacheKey, $ttl, function () use ($type) {
            $response = $this->client->getTarifs($type);
            return $response['data'] ?? [];
        });
    }
    public function findTarif(string $type, string $tarifName): ?array
    {
        $tarifs = $this->getTarifs($type);

        foreach ($tarifs as $tarif) {
            if (($tarif['tarif'] ?? '') === $tarifName) {
                return $tarif;
            }
        }

        return null;
    }
    public function calculateAmount(string $type, string $tarifName, int $period): ?float{
    $tarif = $this->findTarif($type, $tarifName);

    if (! $tarif) {
        return null;
    }

    return (float) $tarif['price'] * $period;
}
    public function refreshCache(string $type): array
    {
        Cache::store('file')->forget("alemtv_tarifs:{$type}");
        return $this->getTarifs($type);
    }
    /**
     * Alem Tv user Search
     */
    public function search(string $type, string $account): array
    {
        return $this->client->search($type, $account);
    }

    /**
     * Alem Tv Pay
     */
    public function payTopUp(?User $user, array $data): array
    {
        $type   = $data['type'];
        $tarif  = $data['tarif'];
        $period = (int) $data['period'];
        $amount = $this->calculateAmount($type, $tarif, $period) ?? 0;
        $payment = PaymentRequest::create([
            'user_id' => $user?->id,
            'type' => 'alem_' . $data['type'],
            'status' => 'sent',
            'amount' => $amount,
            'payment_target' => [
                'tarif'   => $data['tarif'],
                'period'  => $data['period'],
                'value' => $data['account'],
            ],
        ]);

        $payload = [
            'type'      => $data['type'],
            'subject'   => $data['account'],
            'tarif'     => $data['tarif'],
            'period'    => $data['period'],
            'bank_name' => $data['bank_name'],
        ];

        $response = $this->client->topUp($payload);

        if (($response['success'] ?? false) === true) {
            $payment->update([
                'status' => 'pending',
                'external_id' => $response['data']['orderId'] ?? null,
            ]);
        } else {
            $payment->update([
                'status' => 'failed',
            ]);
        }

        return $response;
    }
}
