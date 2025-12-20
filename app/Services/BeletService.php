<?php
namespace  App\Services;
use App\Models\BeletRequest;
use App\Services\Clients\BeletClient;
use Illuminate\Support\Facades\Log;

class BeletService
{
    public function __construct(
        protected BeletClient $client
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
        $log = BeletRequest::create([
            'user_id' => $userId,
            'type' => 'topup',
            'status' => 'sent',
            'payment_target' => [
                'phone' => $payload['phone'],
            ],
        ]);

        $response = $this->client->topUp($payload);

        $log->update([
            'status' => ($response['success'] ?? false)
                ? 'notConfirmed'
                : 'failed',
            'external_id' => $response['data']['order_id'] ?? null,
        ]);

        if (!($response['success'] ?? false)) {
            Log::channel('belet')->error('TopUp failed', [
                'request_id' => $log->id,
                'user_id' => $userId,
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

        if (!$externalId) {
            return [
                'success' => false,
                'error' => [
                    'code' => 4,
                    'message' => 'Invalid Query Params',
                ],
                'data' => null,
            ];
        }
        $topUpRequest = BeletRequest::where('user_id', $userId)
            ->where('type', 'topup')
            ->where('external_id', $externalId)
            ->latest()
            ->first();

        if (!$topUpRequest) {
            return [
                'success' => false,
                'error' => [
                    'code' => 404,
                    'message' => 'TopUp request not found',
                ],
                'data' => null,
            ];
        }

        // 📝 Confirm request log oluştur
        $confirmLog = BeletRequest::create([
            'user_id'     => $userId,
            'type'        => 'confirm',
            'external_id' => $externalId,
            'status'      => 'confirming',
        ]);

        // 🌐 Belet API çağrısı
        $response = $this->client->confirm($payload);

        // 🔄 Status güncelle
        $confirmLog->update([
            'status' => ($response['success'] ?? false)
                ? 'confirmed'
                : 'failed',
        ]);

        // 📌 Log
        if (!($response['success'] ?? false)) {
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
