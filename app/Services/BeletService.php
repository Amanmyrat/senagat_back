<?php

namespace App\Services;

use App\Contracts\PollingPaymentProvider;
use App\Jobs\AutoConfirmPaymentJob;
use App\Models\PaymentRequest;
use App\Services\Clients\BeletClient;
use Illuminate\Support\Facades\Log;

class BeletService implements PollingPaymentProvider
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

    public function topUp(?int $userId, array $payload): array
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
        if (($response['success'] ?? false) && isset($response['data']['order_id'])) {
            AutoConfirmPaymentJob::dispatch(static::class, $payment->id)
                ->delay(now()->addSeconds(30));

            Log::channel('belet')->info('Job dispatched', ['payment_id' => $payment->id]);
        }

        return $response;
    }

    //    public function confirm(?int $userId, array $payload): array
    //    {
    //        $externalId = $payload['orderId'] ?? $payload['pay_id'] ?? null;
    //
    //        if (!$externalId) {
    //            return [
    //                'success' => false,
    //                'error' => ['code' => 4, 'message' => 'Invalid Query Params'],
    //                'data' => null,
    //            ];
    //        }
    //
    //
    //        $payment = PaymentRequest::where('type', 'belet')
    //            ->where('external_id', $externalId)
    //            ->when($userId, fn($q) => $q->where('user_id', $userId))
    //            ->latest()
    //            ->first();
    //
    //        if (!$payment) {
    //            return [
    //                'success' => false,
    //                'error' => ['code' => 404, 'message' => 'Payment request not found'],
    //                'data' => null,
    //            ];
    //        }
    //
    //        return $this->confirmByOrderId($externalId);
    //    }

    public function confirmByOrderId(string $orderId): array
    {
        $topUpRequest = PaymentRequest::where('type', 'belet')
            ->where('external_id', $orderId)
            ->latest()
            ->first();

        if (! $topUpRequest) {
            return ['success' => false, 'error' => ['code' => 404, 'message' => 'Not found']];
        }

        if ($topUpRequest->status === 'confirmed') {
            return ['success' => true, 'data' => ['status' => 'confirmed', 'message' => 'Already confirmed']];
        }

        $response = $this->client->confirm(['orderId' => $orderId]);

        $isConfirmed = ($response['success'] ?? false) === true ||
            ($response['data']['success'] ?? false) === true ||
            str_contains(strtolower($response['data']['message'] ?? ''), 'already confirmed');

        if ($isConfirmed) {
            $topUpRequest->update(['status' => 'confirmed', 'error_message' => null]);
        } else {
            $topUpRequest->update([
                'status' => 'notConfirmed',
                'error_message' => $response['data']['message'] ?? $response['message'] ?? null,
            ]);
        }

        return $response;
    }

    public function pollStatusByOrderId(string|int $id): array
    {
        Log::channel('belet')->info('Polling Metodu Tetiklendi', ['gelen_id' => $id]);

        $payment = is_numeric($id)
            ? PaymentRequest::find($id)
            : PaymentRequest::where('external_id', $id)->first();

        if (! $payment) {
            Log::channel('belet')->warning("Polling: DB'de kayit bulunamadi!");

            return ['success' => true];
        }

        Log::channel('belet')->info('API Sorgusu Hazirlaniyor', [
            'db_id' => $payment->id,
            'gonderilecek_uuid' => $payment->external_id,
        ]);

        $this->confirmByOrderId($payment->external_id);

        $payment->refresh();

        Log::channel('belet')->info('Polling Bitti', [
            'son_durum' => $payment->status,
        ]);

        return [
            'success' => ($payment->status === 'confirmed'),
            'status' => $payment->status,
        ];
    }
}
