<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Http\JsonResponse;

class NewsController extends Controller
{
    /**
     * News
     *
     * @unauthenticated
     *
     * @localizationHeader
     */
    public function index(): JsonResponse
    {
        $location = News::orderBy('sort')->get();

        return new JsonResponse([
            'success' => true,
            'data' => NewsResource::collection($location),
        ], 200);
    }
}
