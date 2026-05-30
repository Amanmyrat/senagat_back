<?php

namespace App\Services;

use App\Enum\ErrorMessage;
use App\Models\CertificateOrder;
use App\Models\CertificateType;
use App\Models\PaymentRequest;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CertificateOrderService
{
    public function create(array $data, $user): array
    {
        $paymentUrl = null;
        if (! $user->profile) {

            throw new \Exception(ErrorMessage::USER_PROFILE_REQUIRED->value);
        }
        $profile = UserProfile::where('user_id', $user->id)->firstOrFail();
       $order = CertificateOrder::create([
            'user_id' => $user->id,
            'profile_id' => $profile->id,
            'certificate_type_id' => $data['certificate_type_id'],
            'home_address' => $data['home_address'] ?? null,
            'bank_branch_id' => $data['bank_branch_id'] ?? null,
            'wants_payment' => $data['wants_payment'],
            'status' => 'pending',
        ]);
        $certificateType = CertificateType::findOrFail($data['certificate_type_id']);

        $paymentStatus = $order->wants_payment
            ? 'pending'
            : 'not_required';
        $paymentRequest = PaymentRequest::create([
            'user_id' => $user->id,
            'type' => 'certificate',
            'related_id' => $order->id,
            'external_id' => $order->id,
            'payment_status' => $paymentStatus,
            'amount' => $certificateType->price,
            'meta' => [
                'certificate_type_id' => $order->certificate_type_id,
                'bank_branch_id' => $order->bank_branch_id,
            ],
        ]);

        if ($order->wants_payment) {
            Log::channel('belet')->info('CERTIFICATE PAYMENT STARTED', [
                'wants_payment' => $order->wants_payment,
            ]);
            Log::channel('belet')->info('CERTIFICATE PAYMENT REQUEST', [
                'url' => config('services.payment_api.url') . '/api/v1/payment/create',
                'payload' => [
                    'location_id' => (string) $order->bank_branch_id,
                    'amount' => (int) $certificateType->getRawOriginal('price'),
                    'type' => 'certificate',
                ],
            ]);
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post(
                config('services.payment_api.url') . '/api/v1/payment/create',
                [
                    'location_id' => (string) $order->bank_branch_id,
                    'amount' => (int) $certificateType->getRawOriginal('price'),
                    'type' => 'certificate',
                ]
            );

            $responseData = $response->json();
            Log::channel('belet')->info('CERTIFICATE PAYMENT RESPONSE', [
                'status' => $response->status(),
                'body' => $response->body(),
                'json' => $response->json(),
            ]);
            $paymentReference =
                $responseData['data']['body']['orderId']
                ?? null;
            $paymentUrl =
                $responseData['data']['body']['formUrl']
                ?? null;
            $order->update([
                'payment_status' => 'pending',
            ]);

            $paymentRequest->update([
                'external_id' => $paymentReference,
            ]);

        } else {
           $order->update([
                'payment_status' => 'not_required',
            ]);
        }
        return [
            'order' => $order,
            'payment_url' => $paymentUrl,
        ];
    }

    public function getPending($user)
    {
        return CertificateOrder::where('user_id', $user->id)
            ->where('status', 'pending')
            ->latest()
            ->first();
    }
}
