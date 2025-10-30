<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CardOrderRequest;
use App\Http\Resources\CardOrderResource;
use App\Services\CardOrderService;

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

        $order = $this->service->createOrder($request->validated(), $request->user());

        return response()->json(['message' => 'Order created successfully.',
            'data' => collect((new CardOrderResource($order))->toArray($request))->except('status','card_title'),

        ], 201);
    }
}

