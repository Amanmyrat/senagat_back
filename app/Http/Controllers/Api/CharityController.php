<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Charity\CharityRequest;
use App\Services\CharityService;
use Illuminate\Http\JsonResponse;

class CharityController extends Controller
{
    /**
     * Charity
     */
    public function store(
        CharityRequest $request,
        CharityService $service
    ): JsonResponse {
        return new JsonResponse(
            $service->create(
                $request->user(),
                $request->validated()
            )
        );
    }
}
