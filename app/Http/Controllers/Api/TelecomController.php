<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TelecomBalanceRequest;
use App\Http\Requests\TelecomTopupRequest;
use App\Http\Resources\TelecomBalanceResource;
use App\Services\TelecomService;
use Illuminate\Http\JsonResponse;

class TelecomController extends Controller
{
    protected TelecomService $telecomService;

    public function __construct(TelecomService $telecomService)
    {
        $this->telecomService = $telecomService;
    }

    /**
     * Telecom balance
     *
     * @queryParam account string required Telecom account number. Example: 12932701
     */
    public function getBalance(TelecomBalanceRequest $request)
    {
        $result = $this->telecomService->getBalance(
            $request->validated('phone'));

        return new TelecomBalanceResource($result);
    }

    /**
     * Telecom Pay
     */
    public function pay(TelecomTopupRequest $request): JsonResponse
    {
        $response = $this->telecomService->create(
            $request->user(),
            $request->validated());

        return new JsonResponse($response);
    }
}
