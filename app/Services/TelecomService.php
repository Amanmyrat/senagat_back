<?php


namespace App\Services;

use App\Contracts\PollingPaymentProvider;
use App\Jobs\AutoConfirmPaymentJob;
use App\Models\PaymentRequest;
use App\Models\User;
use App\Services\Clients\CharityClient;
use App\Services\Clients\TelecomClient;
use Illuminate\Support\Facades\Log;

class TelecomService
{
    public function __construct(
        protected TelecomClient       $client
    )
    {

    }

    public function getBalance(string $account): array
    {
        return $this->client->getBalance($account);
    }
    public function create(?User $user, array $data): array
    {

        $payment = PaymentRequest::create([
            'user_id' => $user?->id,
            'type' => 'telecom',
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
            'phone'=> $data['phone'],
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
