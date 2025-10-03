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
     * @localizationHeader
     */
    public function index(): JsonResponse
    {
        $card = CreditType::get();

        return new JsonResponse([
            'success' => true,
            'data' => CreditTypeResource::collection($card),
        ], 200);
    }
}
