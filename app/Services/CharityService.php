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

    public function create(?User $user, array $data): array
    {

        $payment = PaymentRequest::create([
            'user_id' => $user?->id,
            'type' => 'charity',
            'status' => 'sent',
            'amount' => $data['amount'],
            'payment_target' => [
                'type' => 'phone',
                'value' => $data['phone'],
            ],
            'meta' => [
                'name' => $data['name'],
                'surname' => $data['surname'],
            ],
        ]);

        $payload = [
            'bank_name' =>$data['bank_name'],
            'amount' => $data['amount'],
            'name' => $data['name'],
            'surname' => $data['surname'],
            'phone' => '993'.$data['phone'],
        ];
        $response = $this->client->create($payload);
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


    public function checkStatus(string $orderId): array
    {
        $payment = PaymentRequest::where('external_id', $orderId)->first();
        if (!$payment) {
            return [
                'success' => false,
                'error' => [
                    'code' => 404,
                    'message' => 'Payment request not found',
                ],
                'data' => null,
            ];
        }
        $response = $this->client->checkStatus([
            'orderId' => $orderId,
        ]);

        if (($response['success'] ?? false) !== true) {
            return $response;
        }

        $orderStatus = $response['data']['orderStatus'] ?? null;
        $errorMessage = $response['data']['errorMessage'] ?? null;

        $mappedStatus = match ($orderStatus) {
            2 => 'confirmed',
            1 => 'pending',
            0 => 'failed',
            default => 'pending',
        };

        $payment->update([
            'status' => $mappedStatus,
            'error_message' => $errorMessage,
        ]);

        Log::info('Charity payment status updated', [
            'payment_id' => $payment->id,
            'external_id' => $orderId,
            'status' => $mappedStatus,
        ]);

        return [
            'success' => true,
            'data' => [
                'status' => $mappedStatus,
                'orderStatus' => $orderStatus,
                'message' => $errorMessage,
            ],
        ];
    }

}
