<?php

namespace App\Http\Controllers\Api;

use App\Enum\SuccessMessage;
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
        $location = News::all();

        return new JsonResponse([
            'success' => true,
            'code' => SuccessMessage::NEWS_LISTED->value,
            'data' => NewsResource::collection($location),
        ], 200);
    }
}
