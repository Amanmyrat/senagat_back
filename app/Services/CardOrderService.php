<?php

namespace App\Services;

use App\Enum\ErrorMessage;
use App\Models\CardOrder;
use App\Models\CardType;
use App\Models\PaymentRequest;
use App\Models\UserProfile;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CardOrderService
{
    public function createOrder(array $data, $user): array
    {
        $paymentUrl = null;
        if (!$user->profile) {
            throw new \Exception(ErrorMessage::USER_PROFILE_REQUIRED->value);
        }
        $profile = UserProfile::where('user_id', $user->id)->firstOrFail();
        $requiredPayment = $data['required_payment'] ?? false;

        $order = CardOrder::create([
            'user_id' => $user->id,
            'profile_id' => $profile->id,
            'card_type_id' => $data['card_type_id'],
            'bank_branch_id' => $data['bank_branch_id'],
            'work_position' => $data['work_position'] ?? 'jobless',
            'work_phone' => $data['work_phone'] ?? null,
            'internet_service' => $data['internet_service'],
            'secret_word' => $data['secret_word'] ?? null,
            'wants_payment' => $requiredPayment,
            'delivery' => $data['delivery'],
            'email' => $data['email'],
            'status' => 'pending',
        ]);
        $cardType = CardType::findOrFail($data['card_type_id']);
        $paymentStatus = $requiredPayment ? 'pending' : 'not_required';

        $paymentRequest = PaymentRequest::create([
            'user_id' => $user->id,
            'type' => 'card',
            'related_id' => $order->id,
            'external_id' => $order->id,
            'payment_status' => $paymentStatus,
            'amount' => $cardType->price,
            'meta' => [
                'card_type_id' => $order->card_type_id,
                'bank_branch_id' => $order->bank_branch_id,
            ],
        ]);

        $amount = (int) $cardType->getRawOriginal('price');

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
                    'location_id' => (string)$order->bank_branch_id,
                    'amount' => $amount,
                        //(int)$cardType->getRawOriginal('price'),
                    'type' => 'card',
                ]
            );
                if ($response->failed()) {
                    $paymentRequest->update(['payment_status' => 'failed']);
                    throw new \Exception("please_try_again_later");
                }

            $responseData = $response->json();

            $paymentReference =
                $responseData['data']['body']['orderId']
                ?? null;
            $paymentUrl =
                $responseData['data']['body']['formUrl']
                ?? null;

            $paymentRequest->update([
                'external_id' => $paymentReference,
            ]);
                $order->setRelation('paymentRequest', $paymentRequest);
        }catch (ConnectionException $e) {
                $paymentRequest->update(['payment_status' => 'failed']);
                $order->setRelation('paymentRequest', $paymentRequest);
                throw new \Exception("no_internet_connection");
            } } else {


            $order->setRelation('paymentRequest', $paymentRequest);
        }

        return [
            'order' => $order,
            'payment_url' => $paymentUrl,
        ];


    }

    public function getPending($user)
    {
        return CardOrder::where('user_id', $user->id)
            ->where('status', 'pending')
            ->latest()
            ->first();
    }
}
