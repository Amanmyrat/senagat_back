<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TmCell\BaseTopUpRequest;
use App\Http\Requests\TmCell\TmCellBalanceRequest;
use App\Http\Resources\TelecomBalanceResource;
use App\Services\TmCellService;
use Illuminate\Http\JsonResponse;

class TmCellController extends Controller
{
    protected TmCellService $telecomService;

    public function __construct(TmCellService $telecomService)
    {
        $this->telecomService = $telecomService;
    }
    /**
     * Telecom balance
     * @queryParam account string required Telecom account number. Example: 12932701
     */
    public function getBalance(TmCellBalanceRequest $request)
    {
        $result = $this->telecomService->getBalance(
            $request->validated('phone'));
        return new TelecomBalanceResource($result);

    }

    /**
     * Telecom Pay
     */
    public function pay(BaseTopupRequest $request): JsonResponse
    {
        $response = $this->telecomService->create(
            $request->user(),
            $request->validated());

        return new JsonResponse($response);
    }
}
