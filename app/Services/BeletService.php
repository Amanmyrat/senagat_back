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
        $log = PaymentRequest::create([
            'user_id' => $userId,
            'type' => 'topup',
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

        $log->update([
            'status' => ($response['success'] ?? false)
                ? 'notConfirmed'
                : 'failed',
            'external_id' => $response['data']['order_id'] ?? null,
            'error_code' => $response['error']['code'] ?? null,
            'error_message' => $response['error']['message'] ?? null,
        ]);

        if (! ($response['success'] ?? false)) {
            Log::channel('belet')->error('TopUp failed', [
                'request_id' => $log->id,
                'user_id' => $userId,
                'bank_name' => $payload['bank_name'],
                'response' => $response,
            ]);
        } else {
            Log::channel('belet')->info('TopUp success', [
                'request_id' => $log->id,
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
            ->where('type', 'topup')
            ->where('external_id', $externalId)
            ->latest()
            ->first();

        if (! $topUpRequest) {
            return [
                'success' => false,
                'error' => [
                    'code' => 404,
                    'message' => 'TopUp request not found',
                ],
                'data' => null,
            ];
        }

        $confirmLog = PaymentRequest::create([
            'user_id' => $userId,
            'type' => 'confirm',
            'external_id' => $externalId,
            'status' => 'confirming',
        ]);

        $response = $this->client->confirm($payload);

        $confirmLog->update([
            'status' => ($response['success'] ?? false)
                ? 'confirmed'
                : 'failed',
        ]);

        if (! ($response['success'] ?? false)) {
            Log::channel('belet')->error('Confirm failed', [
                'request_id' => $confirmLog->id,
                'external_id' => $externalId,
                'response' => $response,
            ]);
        } else {
            Log::channel('belet')->info('Confirm success', [
                'request_id' => $confirmLog->id,
                'external_id' => $externalId,
            ]);
        }

        return $response;
    }
}
