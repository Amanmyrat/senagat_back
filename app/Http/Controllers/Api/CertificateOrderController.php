<?php

namespace App\Http\Controllers\Api;

use App\Enum\SuccessMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\CertificateOrderRequest;
use App\Http\Resources\CertificateOrderResource;
use App\Services\CertificateOrderService;
use Exception;
use Illuminate\Http\JsonResponse;

class CertificateOrderController extends Controller
{
    protected CertificateOrderService $service;

    public function __construct(CertificateOrderService $service)
    {
        $this->service = $service;
    }

    /**
     * Create Certificate order
     */
    public function store(CertificateOrderRequest $request)
    {
        try {
            $user = $request->user();
            $order = $this->service->create($request->validated(), $user);

            return new JsonResponse([
                'success' => true,
                'code' => SuccessMessage::CERTIFICATE_ORDER_CREATED->value,
                'data' => collect((new CertificateOrderResource($order))->toArray($request))
                    ->except(['certificate_name', 'status','certificate_price']),
            ], 201);

        } catch (Exception $e) {
            return new JsonResponse([
                'success' => false,
                'error_message' => $e->getMessage(),
             //   'code' => ErrorMessage::CERTIFICATE_ORDER_CREATION_FAILED->value,
            ], 400);
        }
    }
}
