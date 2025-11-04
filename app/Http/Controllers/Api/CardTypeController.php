<?php

namespace App\Http\Controllers\Api;

use App\Enum\SuccessMessage;
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
        $address = CardType::get();

        return new JsonResponse([
            'success' => true,
            'code' => SuccessMessage::CARD_TYPE_LISTED->value,
            'data' => CardTypeResource::collection($address),
        ], 200);
    }
}
