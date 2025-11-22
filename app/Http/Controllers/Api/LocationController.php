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
     * @unauthenticated
     *
     * @localizationHeader
     */
    public function index()
    {
        $locations = Location::all();

        return new JsonResponse([
            'success' => true,
            'data' => LocationResource::collection($locations),
        ], 200);
    }

    /**
     * Get branches that provide services.
     *
     * @unauthenticated
     *
     * @localizationHeader
     */
    public function branchLocations()
    {
        $locations = Location::where('branch_services', true)
            ->where('type', 'Branch')
            ->get();

        return new JsonResponse([
            'success' => true,
            'data' => LocationResource::collection($locations),
        ], 200);
    }
}
