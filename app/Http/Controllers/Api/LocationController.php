<?php

namespace App\Http\Controllers\Api;

use App\Enum\SuccessMessage;
use App\Http\Controllers\Controller;
use App\Http\Resources\LocationResource;
use App\Models\Location;

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

        return response()->json([
            'success' => true,
            'code' => SuccessMessage::LOCATION_LISTED->value,
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

        return response()->json([
            'success' => true,
            'code' => SuccessMessage::BRANCH_LOCATIONS_LISTED->value,
            'data' => LocationResource::collection($locations),
        ], 200);
    }
}
