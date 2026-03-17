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
        Log::channel('charity')->info('--- CHECK STATUS START ---', ['external_id' => $orderId]);
        $payment = PaymentRequest::where('external_id', $orderId)->first();
        if (! $payment) {
            Log::channel('charity')->error('CHECK STATUS: Payment not found in DB', ['external_id' => $orderId]);
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
        Log::channel('charity')->info('API RESPONSE RAW:', ['response' => $response]);
        if (($response['success'] ?? false) !== true) {
            Log::channel('charity')->warning('API SUCCESS FALSE', ['response' => $response]);

            return $response;
        }

        $orderStatus = $response['data']['orderStatus'] ?? null;
        $errorMessage = $response['data']['errorMessage'] ?? null;
        Log::channel('charity')->info('Processing Status Match', ['orderStatus' => $orderStatus]);
        $mappedStatus = match ($orderStatus) {
            2 => 'confirmed',
            0 => 'failed',
            default => 'pending',
        };
        if ($payment->status === $mappedStatus) {
            Log::channel('charity')->info('No Status Change Needed', ['current' => $payment->status, 'new' => $mappedStatus]);
        }
        $payment->update([
            'status' => $mappedStatus,
            'error_message' => $errorMessage,
        ]);
        Log::channel('charity')->info('Charity payment status updated', [
            'payment_id' => $payment->id,
            'external_id' => $orderId,
            'status' => $mappedStatus,
        ]);
        Log::channel('charity')->info('--- CHECK STATUS END ---', ['final_status' => $mappedStatus]);
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

        $payment = is_numeric($id)
            ? PaymentRequest::find($id)
            : PaymentRequest::where('external_id', $id)->first();

        if (! $payment) {

            return ['success' => false];
        }
        if (empty($payment->external_id)) {

            return ['success' => false];
        }
        $this->checkStatus($payment->external_id);

        $payment->refresh();
        return [
            'success' => $payment->status === 'confirmed',
            'status' => $payment->status,
        ];
    }
}
