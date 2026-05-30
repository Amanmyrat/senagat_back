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
            $result = $this->service->createOrder(
                $request->validated(),
                $request->user()
            );

            $response = collect(
                (new CardOrderResource($result['order']))
                    ->toArray($request)
            )->except('status', 'rejection_reasons')
                ->toArray();

            if ($result['payment_url']) {
                $response['payment_url'] = $result['payment_url'];
            }

            return new JsonResponse([
                'success' => true,
                'data' => $response,
            ], 201);

        } catch (Exception $e) {

            return new JsonResponse([
                'success' => false,
                'error_message' => $e->getMessage(),
            ], 400);
        }
    }
}
