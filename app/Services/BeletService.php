<?php

namespace App\Services;

use App\Models\PaymentRequest;
use App\Services\Clients\BeletClient;
use Illuminate\Support\Facades\Log;

class BeletService
{
    public function __construct(
        protected BeletClient $client,
        protected BankResolverService $bankResolver

    ) {}

    public function banks(): array
    {
        return $this->client->getBanks();
    }

    public function getBalanceRecommendations(): array
    {
        return $this->client->getBalanceRecommendations();
    }

    public function checkStatus(int|string $id): array
    {
        return $this->client->checkStatus($id);
    }

    public function checkPhone(string $phone): array
    {
        return $this->client->checkPhone($phone);
    }

    public function topUp(int $userId, array $payload): array
    {
        $bankId = $this->bankResolver->resolveIdByName($payload['bank_name']);
        if (! $bankId) {
            return [
                'success' => false,
                'error' => [
                    'code' => 16,
                    'message' => 'Invalid bank',
                ],
                'data' => null,
            ];
        }
        $payment = PaymentRequest::create([
            'user_id' => $userId,
            'type' => 'belet',
            'status' => 'sent',
            'amount' => $payload['amount_in_manats'],
            'payment_target' => [
                'type' => 'phone',
                'value' => $payload['phone'],
            ],
        ]);
        $beletPayload = [
            'bank_id' => $bankId,
            'amount_in_manats' => $payload['amount_in_manats'],
            'phone' => $payload['phone'],
        ];

        $response = $this->client->topUp($beletPayload);

        $payment->update([
            'status' => ($response['success'] ?? false)
                ? 'notConfirmed'
                : 'failed',
            'external_id' => $response['data']['order_id'] ?? null,
            'error_code' => $response['error']['code'] ?? null,
            'error_message' => $response['error']['message'] ?? null,
        ]);

        if (! ($response['success'] ?? false)) {
            Log::channel('belet')->error('TopUp failed', [
                'request_id' => $payment->id,
                'user_id' => $userId,
                'bank_name' => $payload['bank_name'],
                'response' => $response,
            ]);
        } else {
            Log::channel('belet')->info('TopUp success', [
                'request_id' => $payment->id,
                'external_id' => $response['data']['order_id'] ?? null,
            ]);
        }

        return $response;
    }

    public function confirm(int $userId, array $payload): array
    {
        $externalId = $payload['orderId'] ?? $payload['pay_id'] ?? null;

        if (! $externalId) {
            return [
                'success' => false,
                'error' => [
                    'code' => 4,
                    'message' => 'Invalid Query Params',
                ],
                'data' => null,
            ];
        }
        $topUpRequest = PaymentRequest::where('user_id', $userId)
            ->where('type', 'belet')
            ->where('external_id', $externalId)
            ->latest()
            ->first();

        if (! $topUpRequest) {
            return [
                'success' => false,
                'error' => [
                    'code' => 404,
                    'message' => 'Payment  request not found',
                ],
                'data' => null,
            ];
        }
        if ($topUpRequest->status === 'confirmed') {
            return [
                'success' => true,
                'data' => [
                    'status' => 'confirmed',
                    'message' => 'Already confirmed',
                ],
            ];
        }
        $topUpRequest->update([
            'status' => 'confirming',
        ]);

        $response = $this->client->confirm($payload);

        $topUpRequest->update([
            'status' => ($response['success'] ?? false) ? 'confirmed' : 'failed',
            'error_code' => $response['error']['code'] ?? null,
            'error_message' => $response['error']['message'] ?? null,
        ]);

        if (! ($response['success'] ?? false)) {
            Log::channel('belet')->error('Confirm failed', [
                'request_id' => $topUpRequest->id,
                'external_id' => $externalId,
                'response' => $response,
            ]);
        } else {
            Log::channel('belet')->info('Confirm success', [
                'request_id' => $topUpRequest->id,
                'external_id' => $externalId,
            ]);
        }

        return $response;
    }
    public function confirmByOrderId(string $orderId): array
    {
        $topUpRequest = PaymentRequest::where('type', 'belet')
            ->where('external_id', $orderId)
            ->latest()
            ->first();

        if (!$topUpRequest) {
            return [
                'success' => false,
                'error' => [
                    'code' => 404,
                    'message' => 'Payment request not found',
                ],
                'data' => null,
            ];
        }

        if ($topUpRequest->status === 'confirmed') {
            return [
                'success' => true,
                'data' => [
                    'message' => 'Already confirmed',
                ],
            ];
        }
        $topUpRequest->update([
            'status' => 'confirming',
        ]);


        $response = $this->client->confirm([
            'orderId' => $orderId,
        ]);

        $topUpRequest->update([
            'status' => ($response['success'] ?? false) ? 'confirmed' : 'failed',
            'error_code' => $response['data']['code'] ?? null,
            'error_message' => $response['data']['message'] ?? null,
        ]);

        Log::channel('belet')->info('Belet confirmByOrderId', [
            'payment_id' => $topUpRequest->id,
            'external_id' => $orderId,
            'status' => $topUpRequest->status,
        ]);

        return $response;
    }

}
