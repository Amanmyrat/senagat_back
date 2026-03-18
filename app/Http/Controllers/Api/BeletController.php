<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Belet\BeletBalanceTopUpRequest;
use App\Http\Requests\Belet\CheckPhoneRequest;
use App\Services\BeletService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BeletController extends Controller
{
    public function __construct(
        protected BeletService $beletService
    ) {}

    /**
     * Bank List
     */
    public function banks(): JsonResponse
    {
        return new JsonResponse(
            $this->beletService->banks()
        );
    }

    /**
     * Balance Recommendations
     */
    public function getBalanceRecommendations(): JsonResponse
    {
        return new JsonResponse(
            $this->beletService->getBalanceRecommendations()
        );
    }


    /**
     * Check Phone Balance
     */
    public function checkPhoneBalance(CheckPhoneRequest $request): JsonResponse
    {
        return new JsonResponse(
            $this->beletService->checkPhoneBalance(
                $request->validated('phone')
            )
        );
    }
    /**
     * Belet Balance TopUp
     */
    public function topUp(BeletBalanceTopUpRequest $request): JsonResponse
    {
        return new JsonResponse(
            $this->beletService->topUp(
                auth()->id(),
                $request->validated()
            )
        );
    }

    /**
     * Belet returnUrl
     *
     * @unauthenticated
     */
    public function return(Request $request): JsonResponse
    {
        $request->validate([
            'orderId' => ['required', 'string'],
        ]);

        $orderId = $request->query('orderId');

        return response()->json(
            $this->beletService->confirmByOrderId($orderId)
        );
    }
}
