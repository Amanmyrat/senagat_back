<?php

namespace App\Http\Resources;

use App\Enum\ErrorMessage;
use Illuminate\Http\Resources\Json\JsonResource;

class TelecomBalanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        $data = $this->resource['data'] ?? [];
        $result = $data['result'] ?? null;
        if ($result === 0) {
            return [
                'success' => true,
                'data' => [
                    'balance' => $data['balance'] ?? null,
                ],
            ];
        }
        if ($result === 5) {
            return [
                'success' => false,
                'error' => [
                    'message' => ErrorMessage::ACCOUNT_NOT_FOUNT,
                ],
            ];
        }

        return [
            'success' => false,
            'error' => [
                'message' => $data['comment'] ?? 'unknown_error',
            ],
        ];
    }
}
