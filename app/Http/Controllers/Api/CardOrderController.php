<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CardOrderRequest;
use App\Http\Resources\CardOrderResource;
use App\Services\CardOrderService;
use Exception;
use Illuminate\Http\JsonResponse;

class CardOrderController extends Controller
{
    protected CardOrderService $service;

    public function __construct(CardOrderService $service)
    {
        $this->service = $service;
    }

    /**
     * Create Card order
     */
    public function store(CardOrderRequest $request)
    {

        try {
            $order = $this->service->createOrder($request->validated(), $request->user());

            return new JsonResponse([
                'success' => true,
                'data' => collect((new CardOrderResource($order))->toArray($request))
                    ->except('status'),
            ], 201);

        } catch (Exception $e) {
            return new JsonResponse([
                'success' => false,
                'error_message' => $e->getMessage(),
                //  'code' => ErrorMessage::ORDER_CREATION_FAILED->value,
            ], 400);
        }
    }
}
