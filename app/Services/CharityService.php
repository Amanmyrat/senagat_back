<?php

namespace App\Services;

use App\Contracts\PollingPaymentProvider;
use App\Jobs\AutoConfirmPaymentJob;
use App\Models\PaymentRequest;
use App\Models\User;
use App\Services\Clients\CharityClient;
use Illuminate\Support\Facades\Log;

class CharityService implements PollingPaymentProvider
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
            'bank_name' => $data['bank_name'],
            'amount' => $data['amount'],
            'name' => $data['name'],
            'surname' => $data['surname'],
            'phone' => '993'.$data['phone'],
        ];

        $response = $this->client->create($payload);

        if (($response['success'] ?? false) === true) {
            $orderId = $response['data']['orderId'] ?? null;
            $payment->update([
                'status' => 'pending',
                'external_id' => $response['data']['orderId'] ?? null,

            ]);
            if ($orderId) {
                AutoConfirmPaymentJob::dispatch(
                    static::class,
                    $payment->id,
                    now()
                )->delay(now()->addSeconds(30));
            }
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
        if (! $payment) {
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

    public function pollStatusByOrderId(string|int $id): array
    {
        Log::channel('belet')->info('Polling Metodu Tetiklendi (Charity)', ['gelen_id' => $id]);

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

        $this->checkStatus($payment->external_id);

        $payment->refresh();

        Log::channel('belet')->info('Polling Bitti', [
            'son_durum' => $payment->status,
        ]);

        return [
            'success' => $payment->status === 'confirmed',
            'status' => $payment->status,
        ];
    }
}
