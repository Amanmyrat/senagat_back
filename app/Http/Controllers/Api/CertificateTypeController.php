<?php

namespace App\Http\Controllers\Api;

use App\Enum\SuccessMessage;
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
        $location = CertificateType::all();

        return new JsonResponse([
            'success' => true,
            'code' => SuccessMessage::CERTIFICATE_TYPE_LISTED->value,
            'data' => FormTypeResource::collection($location),
        ], 200);
    }
}
