<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CardTypeResource;
use App\Models\CardType;
use Illuminate\Http\JsonResponse;

class CardTypeController extends Controller
{
    /**
     * Card Types
     *
     * @localizationHeader
     */
    public function index(): JsonResponse
    {
        $address = CardType::get();

        return new JsonResponse([
            'success' => true,
            'data' => CardTypeResource::collection($address),
        ], 200);
    }
}
