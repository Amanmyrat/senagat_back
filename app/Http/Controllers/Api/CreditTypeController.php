<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CreditTypeResource;
use App\Models\CreditType;
use Illuminate\Http\JsonResponse;

class CreditTypeController extends Controller
{
    /**
     * Credit Types
     *
     * @unauthenticated
     *
     * @localizationHeader
     */
    public function index(): JsonResponse
    {
        $credit = CreditType::orderBy('sort')->get();

        return new JsonResponse([
            'success' => true,
            'data' => CreditTypeResource::collection($credit),
        ], 200);
    }

    /**
     * Credit  Details
     *
     * @unauthenticated
     *
     * @localizationHeader
     */
    public function show($id): JsonResponse
    {
        $credit = CreditType::find($id);
        if (! $credit) {
            return new JsonResponse([
                'success' => false,
            ], 404);

        }

        return new JsonResponse([
            'success' => true,
            'data' => new CreditTypeResource($credit),
        ]);
    }
}
