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
     * @unauthenticated
     *
     * @localizationHeader
     */
    public function index(): JsonResponse
    {
        $cards = CardType::get();

        return new JsonResponse([
            'success' => true,
            'data' => CardTypeResource::collection($cards),
        ], 200);
    }

    /**
     * Card  Details
     *
     * @unauthenticated
     *
     * @localizationHeader
     */
    public function show($id): JsonResponse
    {
        $card = CardType::find($id);
        if (! $card) {
            return new JsonResponse([
                'success' => false,
            ], 404);

        }

        return new JsonResponse([
            'success' => true,
            'data' => new CardTypeResource($card),
        ]);
    }
}
