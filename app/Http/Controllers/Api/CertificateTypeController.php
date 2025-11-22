<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FormTypeResource;
use App\Models\CertificateType;
use Illuminate\Http\JsonResponse;

class CertificateTypeController extends Controller
{
    /**
     * Certificate Type
     *
     * @unauthenticated
     *
     * @localizationHeader
     */
    public function index(): JsonResponse
    {
        $location = CertificateType::orderBy('sort')->get();

        return new JsonResponse([
            'success' => true,
            'data' => FormTypeResource::collection($location),
        ], 200);
    }
}
