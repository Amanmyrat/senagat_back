<?php

namespace App\Services;

use App\Models\PaymentRequest;
use App\Models\User;
use App\Services\Clients\CharityClient;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Log;

class CharityService
{
    public function __construct(
        protected BankResolverService $bankResolver,
        protected CharityClient $client
    ) {}

    public function create(User $user, array $data): array
    {

        $payment = PaymentRequest::create([
            'user_id' => $user->id,
            'type' => 'charity',
            'status' => 'sent',
            'amount' => $data['amount'],
            'payment_target' => [
                'type' => 'phone',
                'value' => $user->phone,
            ],
        ]);
        $profile = $user->profile;
        $payload = [
            'bank_name' =>$data['bank_name'],
            'amount' => $data['amount'],
            'name' => $profile->first_name,
            'surname' => $profile->last_name,
            'phone' => '993'.$user->phone,
        ];
        $response = $this->client->create($payload);
        if (($response['success'] ?? false) === true) {
            $payment->update([
                'status' => 'pending',
                'external_id' => $response['data']['payment_id'] ?? null,
            ]);
        } else {
            $payment->update([
                'status' => 'failed',
            ]);
        }

        return $response;

    }


    public function checkStatus(string $orderId): array
    {
        return $this->client->checkStatus([
            'orderId' => $orderId,
        ]);
    }

}
