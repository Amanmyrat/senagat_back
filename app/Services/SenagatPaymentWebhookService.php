<?php

namespace App\Services;

use App\Models\PaymentRequest;
use Illuminate\Support\Facades\Log;

class SenagatPaymentWebhookService
{
    public function handle(string $externalId, string $status, string $provider): bool
    {
        $payment = PaymentRequest::where('external_id', $externalId)->first();

        if (! $payment) {
            Log::channel('payment_webhook')->warning('Payment not found', [
                'external_id' => $externalId,
                'type'    => $provider,
            ]);
            return false;
        }
        $payment->update(['payment_status' => $status]);
        Log::channel('payment_webhook')->info('Payment status updated', [
            'external_id' => $externalId,
            'status'      => $status,
            'type'    => $provider,
        ]);
        return true;
    }
}
