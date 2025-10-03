<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LocationResource;
use App\Models\Location;
use Illuminate\Http\JsonResponse;

class LocationController extends Controller
{
    /**
     * Location
     *
     * @localizationHeader
     */
    public function index(): JsonResponse
    {
        $location = Location::get();

        return new JsonResponse([
            'success' => true,
            'data' => LocationResource::collection($location),
        ], 200);
    }
}
