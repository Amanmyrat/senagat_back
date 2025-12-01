<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\InternationalPaymentTypeResource;
use App\Models\InternationalPaymentTypes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InternationalPaymentTypesController extends Controller
{


    /**
     * International Payment Types
     *
     * @unauthenticated
     *
     * @localizationHeader
     */
    public function index(): JsonResponse
    {
        $payment = InternationalPaymentTypes::get();

        return new JsonResponse([
            'success' => true,
            'data' => InternationalPaymentTypeResource::collection($payment),
        ], 200);
    }
}
