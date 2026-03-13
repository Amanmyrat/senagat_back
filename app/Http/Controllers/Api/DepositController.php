<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DepositTypeDetailsResource;
use App\Http\Resources\DepositTypeResource;
use App\Models\DepositType;
use Illuminate\Http\JsonResponse;

class DepositController extends Controller
{
    /**
     * Deposit Types
     *
     * @unauthenticated
     *
     * @localizationHeader
     */
    public function index(): JsonResponse
    {
        $depositTypes = DepositType::orderBy('sort')->get();

        return new JsonResponse([
            'success' => true,
            'data' => DepositTypeResource::collection($depositTypes),
        ], 200);
    }

    /**
     * Deposit  Details
     *
     * @unauthenticated
     *
     * @localizationHeader
     */
    public function show($id): JsonResponse
    {
        $deposit = DepositType::find($id);
        if (! $deposit) {
            return new JsonResponse([
                'success' => false,
            ], 404);

        }

        return new JsonResponse([
            'success' => true,
            'data' => new DepositTypeDetailsResource($deposit),
        ]);
    }
}
