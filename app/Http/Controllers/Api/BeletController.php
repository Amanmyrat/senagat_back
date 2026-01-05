<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Belet\BalanceConfirmRequest;
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
     * Check Status
     */
    public function checkStatus(int|string $id): JsonResponse
    {
        return new JsonResponse(
            $this->beletService->checkStatus($id)
        );
    }

    /**
     * Check Phone
     */
    public function checkPhone(CheckPhoneRequest $request): JsonResponse
    {
        return new JsonResponse(
            $this->beletService->checkPhone(
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
     * Balance Confirm
     */
    public function confirm(BalanceConfirmRequest $request): JsonResponse
    {
        return new JsonResponse(
            $this->beletService->confirm(
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
