<?php

namespace App\Http\Controllers\Api;

use App\Enum\ErrorMessage;
use App\Enum\SuccessMessage;
use App\Http\Controllers\Controller;
use App\Http\Resources\CardTypeResource;
use App\Http\Resources\DepositTypeDetailsResource;
use App\Http\Resources\DepositTypeResource;
use App\Models\DepositType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
        $address = DepositType::get();

        return new JsonResponse([
            'success' => true,
            'code' => SuccessMessage::Deposit_TYPE_LISTED->value,
            'data' => DepositTypeResource::collection($address),
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
    if (!$deposit) {
        return response()->json([
            'success' => false,
            'error_message' => ErrorMessage::DEPOSIT_TYPE_NOT_FOUND->value,
        ], 404);

}
        return response()->json([
            'success' => true,
            'code' => SuccessMessage::Deposit_TYPE_DETAILS_LISTED->value,
            'data' => new DepositTypeDetailsResource($deposit),
        ]);
    }
}
