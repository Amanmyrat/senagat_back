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
    public static $wrap = null;
    public function toArray($request): array
    {
        $data = $this->resource['data'] ?? [];
        $result = $data['result'] ?? null;
        if ($result === 0) {
            return [
                'success' => true,
                'data' => [
                    'balance' => rtrim(number_format((float)($data['balance'] ?? 0), 2), '0'),
                ],
            ];
        }
        if ($result === 5) {
            return [
                'success' => false,
                'message' => ErrorMessage::ACCOUNT_NOT_FOUNT,
            ];
        }

        return [
            'success' => false,
            'message' => $data['comment'] ?? 'unknown_error',
        ];
    }
}
