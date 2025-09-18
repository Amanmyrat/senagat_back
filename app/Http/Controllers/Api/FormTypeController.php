<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FormTypeResource;
use App\Models\FormType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FormTypeController extends Controller
{
    /**
     * Form Type
     *
     * @localizationHeader
     */
    public function index(): JsonResponse
    {
        $location = FormType::all();

        return new JsonResponse([
            'success' => true,
            'data' => FormTypeResource::collection($location),
        ], 200);
    }
}
