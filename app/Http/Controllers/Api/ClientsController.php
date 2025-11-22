<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Models\Clients;
use Illuminate\Http\JsonResponse;

class ClientsController extends Controller
{
    /**
     * Clients
     *
     * @unauthenticated
     *
     * @localizationHeader
     */
    public function index(): JsonResponse
    {
        $clients = Clients::orderBy('sort')->get();

        return new JsonResponse([
            'success' => true,

            'data' => ClientResource::collection($clients),
        ], 200);
    }
}
