<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CertificateOrderRequest;
use App\Http\Requests\InternationalPaymentOrderRequest;
use App\Http\Resources\CertificateOrderResource;
use App\Http\Resources\InternationalPaymentOrderResource;
use App\Services\InternationalPaymentOrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;
class InternationalPaymentOrderController extends Controller
{
    protected InternationalPaymentOrderService $service;

    public function __construct(InternationalPaymentOrderService $service)
    {
        $this->service = $service;
    }

    /**
     * International Payment order
     */
    public function store(InternationalPaymentOrderRequest $request)
    {
        try {
            $user = $request->user();
            $order = $this->service->create($request->validated(), $user);

            return new JsonResponse([
                'success' => true,
                'data' => new InternationalPaymentOrderResource($order),

            ], 201);

        } catch (Exception $e) {
            return new JsonResponse([
                'success' => false,
                'error_message' => $e->getMessage(),

            ], 400);
        }
    }
}



