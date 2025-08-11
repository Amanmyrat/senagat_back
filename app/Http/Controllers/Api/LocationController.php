<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LocationResource;
use App\Models\Location;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
/**
 * Location.
 *
 * @queryParam lang string required Example: en, ru, tk.
 */
class LocationController extends Controller
{
    public function  index(Request $request){
        $request->query('lang', app()->getLocale());
        $location = Location::get();

        return new JsonResponse([
            'succes'=>true,
            'data'=> LocationResource::collection($location)
        ],200) ;
    }
}
