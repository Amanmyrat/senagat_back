<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ApiBaseController extends Controller
{

    protected function respondSuccess($data = [], string $message = '', int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }


    protected function respondError(string $message = 'Error', int $code = 400, $errors = []): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $code);
    }


    protected function respondWithItem($item, $transformer, $message = '', $code = 200): JsonResponse
    {
        $data = $transformer->transform($item);

        return $this->respondSuccess($data, $message, $code);
    }


    protected function respondWithCollection($collection, $transformer, $message = '', $code = 200): JsonResponse
    {
        $data = $collection->map(fn($item) => $transformer->transform($item));

        return $this->respondSuccess($data, $message, $code);
    }
}
