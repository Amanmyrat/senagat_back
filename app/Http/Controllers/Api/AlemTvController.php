<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AlemTvSearchRequest;
use App\Http\Requests\AlemTvTopupRequest;
use App\Services\AlemTvService;
use Illuminate\Http\JsonResponse;

class AlemTvController extends Controller
{
    public function __construct(
        protected AlemTvService $alemTvService
    ) {}

    /**
     * Alem Tv Search
     */

    public function search(AlemTvSearchRequest $request): JsonResponse
    {
        $data = $request->validated();

        $response = $this->alemTvService->search(
            $data['type'],
            $data['account']
        );

        return response()->json($response);
    }
    /**
     * Alem TV Top Up
     */
    public function payTopUp(AlemTvTopupRequest $request): JsonResponse
    {
        $response = $this->alemTvService->payTopUp(
            $request->user(),
            $request->validated()
        );
        return response()->json($response);
    }
}
