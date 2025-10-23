<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CardOrderRequest;
use App\Http\Requests\CardOrderStep2Request;
use App\Http\Resources\CardOrderResource;
use App\Http\Resources\CardOrderStep2Resource;
use App\Models\CardOrder;
use App\Services\CardOrderService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class CardOrderController extends Controller
{
    protected CardOrderService $service;

    public function __construct(CardOrderService $service)
    {
        $this->service = $service;
    }


    /**
     * Create Card order step 1
     */

    public function storeStep1(CardOrderRequest $request)
    {
//        $order = $this->cardOrderService->createStep1($request->validated(), $request->user());
        $order = $this->service->createStep1($request->validated(), $request->user());
        return response()->json(['message' => 'Step 1 successfully.', 'data' => new CardOrderResource($order)], 201);
    }

    public function storeStep2(CardOrderStep2Request $request)
    {
        $order = CardOrder::where('id', $request->order_id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        if ($order->status !== 'draft') {
            return response()->json(['message' => 'This order has already been completed or is being processed.'], 400);
        }

        $updated = $this->service->completeStep2($order, $request->validated());

        return response()->json(['message' => 'Step 2 successfully.', 'data' => new CardOrderStep2Resource($updated)]);
    }
}
