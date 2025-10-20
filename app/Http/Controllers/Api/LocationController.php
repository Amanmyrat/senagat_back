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
     * @offersFilter
     */
    public function index(Request $request)
    {
        if (app()->runningInConsole() && app()->environment('scramble')) {
            return response()->json([
                'success' => true,
                'data' => [],
            ]);
        }

        $query = Location::query();

        if ($request->boolean('offers_credit')) {
            $query->where('offers_credit', true);
        }

        if ($request->boolean('offers_card')) {
            $query->where('offers_card', true);
        }

        if ($request->boolean('offers_certificate')) {
            $query->where('offers_certificate', true);
        }

        $locations = $query->get();

        return response()->json([
            'success' => true,
            'data' => LocationResource::collection($locations),
        ]);
    }
}
