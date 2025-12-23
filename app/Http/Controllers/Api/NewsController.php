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

        $news = News::orderBy('published_at', 'desc')->get();

        return new JsonResponse([
            'success' => true,
            'data' => NewsResource::collection($news),
        ], 200);
    }
}
