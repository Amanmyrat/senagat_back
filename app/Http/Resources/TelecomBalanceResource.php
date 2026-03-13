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
        $result = $this->resource['result'] ?? null;
        if ($result === 0) {
            return [
                'success' => true,
                'data' => [
                    'balance' => $this->resource['balance'],
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

        return $this->resource;
    }
}
