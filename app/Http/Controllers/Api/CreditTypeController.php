<?php

namespace App\Http\Controllers\Api;

use App\Enum\SuccessMessage;
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
        $card = CreditType::get();

        return new JsonResponse([
            'success' => true,
            'code' => SuccessMessage::CREDIT_TYPE_LISTED->value,
            'data' => CreditTypeResource::collection($card),
        ], 200);
    }
}
