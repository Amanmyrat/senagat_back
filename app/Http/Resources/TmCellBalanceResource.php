<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TmCellBalanceResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request): array
    {
        $success = $this->resource['success'] ?? false;

        if (! $success) {
            $error = $this->resource['error'] ?? [];
            $message = $error['message'] ?? $this->resource['message'] ?? 'unknown_error';

            return [
                'success' => false,
                'message' => $message,
            ];
        }

        $data = $this->resource['data'] ?? [];

        return [
            'success' => true,
            'data' => [
                'phone'    => $data['phone'] ?? null,
                'balance'  => (float) sprintf('%.2f', (float) ($data['balance'] ?? 0)),
                'currency' => $data['currency'] ?? 'TMT',
            ],
        ];
    }
}
