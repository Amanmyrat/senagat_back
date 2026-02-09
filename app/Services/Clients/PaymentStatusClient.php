<?php

namespace App\Services\Clients;

use App\Models\PaymentRequest;
use Illuminate\Support\Facades\Http;

class PaymentStatusClient
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.payment_api.url');
    }

    protected function client()
    {
        return Http::withHeaders([
            'Accept' => 'application/json',
        ]);
    }

    /**
     * Check payment status by order_id
     */
    public function checkStatus(string $orderId, ?string $token = null): array
    {
        try {
            $payment = PaymentRequest::where('external_id', $orderId)
                ->select('status', 'type')
                ->first();

            if (! $payment) {
                return [
                    'success' => false,
                    'error' => [
                        'code' => 404,
                        'message' => 'Payment request not found with ID: '.$orderId,
                    ],
                    'status' => null,
                ];
            }

            return [
                'success' => true,
                'status' => $payment->status,

            ];

        } catch (\Throwable $e) {
            return [
                'success' => false,
                'error' => [
                    'code' => 500,
                    'message' => 'Database error: '.$e->getMessage(),
                ],
                'status' => null,
            ];
        }
    }
}
