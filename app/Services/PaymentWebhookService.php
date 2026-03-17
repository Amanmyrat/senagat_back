<?php

namespace App\Services;

use App\Models\PaymentRequest;
use Illuminate\Support\Facades\Log;

class PaymentWebhookService
{
    public function handle(string $externalId, string $status, string $provider): bool
    {
        $payment = PaymentRequest::where('external_id', $externalId)->first();

        if (! $payment) {
            Log::channel('payment_webhook')->warning('Payment not found', [
                'external_id' => $externalId,
                'provider'    => $provider,
            ]);
            return false;
        }
        $payment->update(['status' => $status]);
        Log::channel('payment_webhook')->info('Payment status updated', [
            'external_id' => $externalId,
            'status'      => $status,
            'provider'    => $provider,
        ]);
        return true;
    }
}
