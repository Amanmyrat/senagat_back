<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LocationResource;
use App\Models\Location;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Location.
     *
     * @queryParam lang string required Example: en, ru, tk.
     */
    public function  index(Request $request): JsonResponse
    {

        $request->query('lang', app()->getLocale());
        $location = Location::get();

        return new JsonResponse([
            'success'=>true,
            'data'=> LocationResource::collection($location)
        ],200) ;
    }
}
