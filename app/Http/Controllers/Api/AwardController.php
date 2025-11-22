<?php

namespace App\Http\Controllers\Api;

use App\Enum\ErrorMessage;
use App\Http\Controllers\Controller;
use App\Http\Resources\AwardDetailsResource;
use App\Http\Resources\AwardResource;
use App\Models\Award;
use Illuminate\Http\JsonResponse;

class AwardController extends Controller
{
    /**
     * Awards
     *
     * @unauthenticated
     *
     * @localizationHeader
     */
    public function index(): JsonResponse
    {
        $awards = Award::orderBy('sort')->get();

        return new JsonResponse([
            'success' => true,
            'data' => AwardResource::collection($awards),
        ], 200);
    }

    /**
     * Award Details
     *
     * @unauthenticated
     *
     * @localizationHeader
     */
    public function show($id): JsonResponse
    {

        $award = Award::find($id);

        if (! $award) {
            return new JsonResponse([
                'success' => false,
                'error_message' => ErrorMessage::TARIFF_TYPE_NOT_FOUND->value,
            ], 404);

        }

        return new JsonResponse([
            'success' => true,
            'data' => new AwardDetailsResource($award),
        ]);
    }
}
