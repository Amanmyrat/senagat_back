<?php

namespace App\Services;

use App\Models\PaymentRequest;
use App\Models\User;
use App\Services\Clients\AlemTvClient;

class AlemTvService
{
    public function __construct(protected AlemTvClient $client) {}

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
        $payment = PaymentRequest::create([
            'user_id' => $user?->id,
            'type' => 'alem_tv' . $data['type'],
            'status' => 'sent',
            'amount' => $data['period'] ?? 0,
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
