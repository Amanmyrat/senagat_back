<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Charity\CharityRequest;
use App\Http\Requests\CheckPaymentStatusRequest;
use App\Services\CharityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CharityController extends Controller
{
    protected CharityService $charityService;

    public function __construct(CharityService $charityService)
    {
        $this->charityService = $charityService;
    }
    /**
     * Charity
     */

    public function store(CharityRequest $request): JsonResponse {
        $response = $this->charityService->create(
            $request->user(),
            $request->validated());

        return new JsonResponse($response);
    }
    /**
     * Charity status
     */
    public function checkStatus(CheckPaymentStatusRequest $request): JsonResponse
    {
        return new JsonResponse(
            $this->charityService->checkStatus(
                $request->validated('orderId')
            )
        );
    }
    /**
     * Bank returnUrl
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
            $this->charityService->checkStatus($orderId)
        );
    }
}
