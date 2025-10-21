<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LocationResource;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Location
     *
     * @localizationHeader
     *
     */
    public function index()
    {
        $locations = Location::all();

        return response()->json([
            'success' => true,
            'data' => LocationResource::collection($locations),
        ]);
    }

    /**
     * Get branches that provide services.
     *
     * @localizationHeader
     *
     */
    public function branchLocations()
    {
        $locations = Location::where('branch_services', true)
            ->where('type', 'Branch')
            ->get();

        return response()->json([
            'success' => true,
            'data' => LocationResource::collection($locations),
        ]);
    }
}
