<?php

namespace App\Services;

use App\Models\PaymentRequest;
use App\Models\User;
use App\Services\Clients\AstuClient;

class AstuService
{
    public function __construct(protected AstuClient $client) {}

    public function getBalance(string $phone, string $type): array
    {
        return $this->client->getBalance($phone, $type);
    }

    public function create(?User $user, array $data): array
    {

        $payment = PaymentRequest::create([
            'user_id' => $user?->id,
            'type' => 'astu '.$data['type'],
            'status' => 'sent',
            'amount' => $data['amount'],
            'payment_target' => [
                'type' => 'phone',
                'value' => $data['phone'],
            ],
        ]);

        $payload = [
            'bank_name' => $data['bank_name'],
            'amount' => $data['amount'],
            'account' => $data['phone'],
            'type' => $data['type'],
        ];

        $response = $this->client->create($payload);

        if (($response['success'] ?? false) === true) {
            $orderId = $response['data']['orderId'] ?? null;
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
