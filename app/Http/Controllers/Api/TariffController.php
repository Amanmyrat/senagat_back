<?php

namespace App\Http\Controllers\Api;

use App\Enum\ErrorMessage;
use App\Http\Controllers\Controller;
use App\Http\Resources\TariffDetailsResource;
use App\Http\Resources\TariffResource;
use App\Models\TariffCategory;
use Illuminate\Http\JsonResponse;

class TariffController extends Controller
{
    /**
     * Tariff Categories with details
     *
     * @unauthenticated
     *
     * @localizationHeader
     */
    public function index(): JsonResponse
    {


        $tariff = TariffCategory::with(['details' => function($q){
            $q->orderBy('sort');
        }])->orderBy('sort')->get();

        return new JsonResponse([
            'success' => true,
            'data' => TariffResource::collection($tariff),
        ], 200);
    }

}
