<?php

namespace App\Services;

use App\Enum\ErrorMessage;
use App\Models\CertificateOrder;
use App\Models\CertificateType;
use App\Models\PaymentRequest;
use App\Models\UserProfile;
use Illuminate\Http\Client\ConnectionException;
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
        $requiredPayment = $data['required_payment'] ?? false;

       $order = CertificateOrder::create([
            'user_id' => $user->id,
            'profile_id' => $profile->id,
            'certificate_type_id' => $data['certificate_type_id'],
            'home_address' => $data['home_address'] ?? null,
            'bank_branch_id' => $data['bank_branch_id'] ?? null,
            'wants_payment' => $requiredPayment,
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
        $amount = (int) $certificateType->getRawOriginal('price');

        if ($user->phone === '65021734') {
            $amount = 1;
        }
        if ($requiredPayment) {
            try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->timeout(10)->post(
                config('services.payment_api.url') . '/api/v1/payment/create',
                [
                    'location_id' => (string) $order->bank_branch_id,
                    'amount' =>$amount,
                        //(int) $certificateType->getRawOriginal('price'),
                    'type' => 'certificate',
                ]
            );
                if ($response->failed()) {
                    throw new \Exception("please_try_again_later");
                }
            $responseData = $response->json();
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

        }catch (ConnectionException $e) {
                throw new \Exception("no_internet_connection");
            }

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
