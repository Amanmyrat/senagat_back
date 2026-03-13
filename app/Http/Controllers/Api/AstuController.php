<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AstuBalanceRequest;
use App\Http\Requests\AstuTopUpRequest;
use App\Http\Resources\AstuBalanceResource;
use App\Services\AstuService;
use Illuminate\Http\JsonResponse;

class AstuController extends Controller
{
    protected AstuService $astuService;

    public function __construct(AstuService $astuService)
    {
        $this->astuService = $astuService;
    }

    /**
     * Astu balance
     *
     * @queryParam account string required Astu account number. Example: 12932701
     */
    public function getBalance(AstuBalanceRequest $request)
    {
        $data = $request->validated();

        $result = $this->astuService->getBalance(
            $data['phone'],
            $data['type']
        );

        return new AstuBalanceResource($result);

    }

    /**
     * Astu Pay
     */
    public function pay(AstuTopUpRequest $request): JsonResponse
    {
        $response = $this->astuService->create(
            $request->user(),
            $request->validated());

        return new JsonResponse($response);
    }
}
