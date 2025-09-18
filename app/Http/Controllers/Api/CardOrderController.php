<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CardOrderRequest;
use App\Http\Resources\CardOrderResource;
use App\Services\CardOrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
        $user = $request->user();
        $order = $this->service->create($request->validated(), $user);

        return new JsonResponse([
            'success' => true,
            'data' => new CardOrderResource($order),
        ],200);
    }
}
