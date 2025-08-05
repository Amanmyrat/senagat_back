<?php

namespace App\Traits;

trait ApiResponse
{
    protected function success(string $message, array $data = [], int $code = 200)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function error(string $message, int $code = 400)
    {
        return response()->json([
            'status' => false,
            'message' => $message
        ], $code);
    }
}
