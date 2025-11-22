<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExchangeRateResource;
use App\Models\ExchangeRate;
use Illuminate\Http\JsonResponse;

class ExchangeRateController extends Controller
{
    /**
     * Exchange Rate
     *
     * @unauthenticated
     *
     * @localizationHeader
     */
    public function index(): JsonResponse
    {
        $currency = ExchangeRate::orderBy('sort')->get();

        return new JsonResponse([
            'success' => true,
            'data' => ExchangeRateResource::collection($currency),
        ], 200);
    }
}
