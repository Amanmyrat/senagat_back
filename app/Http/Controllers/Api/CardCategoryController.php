<?php

namespace App\Http\Controllers\Api;

use App\Enum\ErrorMessage;
use App\Http\Controllers\Controller;
use App\Http\Resources\CardCategoryResource;
use App\Models\CardCategory;
use Illuminate\Http\JsonResponse;

class CardCategoryController extends Controller
{
    /**
     * Our Contact Address List
     *
     * @localizationHeader
     */
    public function cards(): JsonResponse
    {
        $card = CardCategory::orderBy('sort')->get();

        return new JsonResponse([
            'success' => true,
            'code' => ErrorMessage::CARDS_RETRIEVED->value,
            'data' => CardCategoryResource::collection($card),
        ], 200);
    }
}
