<?php

namespace App\Http\Controllers\Api;

use App\Enum\ErrorMessage;
use App\Enum\SuccessMessage;
use App\Http\Controllers\Controller;
use App\Http\Resources\TariffDetailsResource;
use App\Http\Resources\TariffResource;
use App\Models\TariffCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TariffController extends Controller
{

    /**
     * Tariff Categories
     *
     * @unauthenticated
     *
     * @localizationHeader
     */
    public function index(): JsonResponse
    {

        $tariff = TariffCategory::all();
        return new JsonResponse([
            'success' => true,
            'code' => SuccessMessage::Deposit_TYPE_LISTED->value,
            'data' =>  TariffResource::collection($tariff),
        ], 200);
    }
    /**
     * Tariff Details
     *
     * @unauthenticated
     *
     * @localizationHeader
     */
    public function show($id): JsonResponse
    {

           $tariff = TariffCategory::with('details')->find($id);

        if (!$tariff) {
            return response()->json([
                'success' => false,
                'error_message' => ErrorMessage::TARIFF_TYPE_NOT_FOUND->value,
            ], 404);

        }
        return response()->json([
            'success' => true,
            'code' => SuccessMessage::Deposit_TYPE_DETAILS_LISTED->value,
            'data' => new TariffDetailsResource($tariff),
        ]);
    }
}
