<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CdmaBalanceResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request): array
    {
        $success = $this->resource['success'] ?? false;

        if (! $success) {
            $error = $this->resource['error'] ?? [];
            $message = $error['message'] ?? $this->resource['message'] ?? 'unknown_error';
            $formattedMessage = strtolower(str_replace(' ', '_', $message));

            return [
                'success' => false,
                'message' => $formattedMessage,
            ];
        }
        $data = $this->resource['data'] ?? [];

        return [
            'success' => true,
            'data'    => [
                'phone'    => $data['phone'] ?? null,
                'balance'  => sprintf('%.2f', (float) ($data['balance'] ?? 0)),
                'currency' => $data['currency'] ?? 'TMT',
            ],
        ];
    }
}
