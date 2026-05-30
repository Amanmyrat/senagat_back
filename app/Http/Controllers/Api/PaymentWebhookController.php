<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SenagatWebhookPaymentRequest;
use App\Http\Requests\WebhookPaymentRequest;
use App\Models\PaymentRequest;
use App\Services\PaymentWebhookService;
use App\Services\SenagatPaymentWebhookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class PaymentWebhookController extends Controller
{
    public function __construct(
        private PaymentWebhookService $webhookService,
        private SenagatPaymentWebhookService $senagatWebhookService
    ) {}
    /**
     * Payment Webhook
     *
     * @unauthenticated
     */
    public function handle(WebhookPaymentRequest $request)
    {
        $found = $this->webhookService->handle(
            $request->external_id,
            $request->status,
            $request->provider,
        );

        return $found
            ? new JsonResponse(['status' => true])
            : new JsonResponse(['status' => false, 'message' => 'Payment not found'], 404);
    }
    /**
     * Senagat Payment Webhook
     *
     *
     */
    public function update(SenagatWebhookPaymentRequest $request)
    {
        $found = $this->senagatWebhookService->handle(
            $request->external_id,
            $request->status,
            $request->type,
        );

        return $found
            ? new JsonResponse(['status' => true])
            : new JsonResponse(['status' => false, 'message' => 'Payment not found'], 404);
    }
}
