<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cdma\CdmaBalanceRequest;
use App\Http\Requests\TmCell\BaseTopUpRequest;
use App\Http\Resources\CdmaBalanceResource;
use App\Services\CdmaService;
use Illuminate\Http\JsonResponse;

class CdmaController extends Controller
{
    protected CdmaService $cdmaService;

    public function __construct(CdmaService $cdmaService)
    {
        $this->cdmaService = $cdmaService;
    }

    /**
     * CDMA balance
     *
     * @queryParam phone string required CDMA phone number. Example: 60101009
     */
    public function getBalance(CdmaBalanceRequest $request)
    {
        $result = $this->cdmaService->getBalance(
            $request->validated('phone')
        );

        return new CdmaBalanceResource($result);
    }

    /**
     * CDMA Pay
     */
    public function pay(BaseTopUpRequest $request): JsonResponse
    {
        $response = $this->cdmaService->create(
            $request->user(),
            $request->validated()
        );

        return new JsonResponse($response);
    }
}
