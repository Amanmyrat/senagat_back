<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactAddressResources;
use App\Models\ContactAddress;
use Illuminate\Http\JsonResponse;

class ContactAddressController extends Controller
{
    /**
     * Our Contact Address List
     *
     * @localizationHeader
     */
    public function index(): JsonResponse
    {
        $address = ContactAddress::get();

        return new JsonResponse([
            'success' => true,
            'data' => ContactAddressResources::collection($address),
        ], 200);
    }
}
