<?php

namespace App\Http\Resources;

use App\Enum\ErrorMessage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AstuBalanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        if (($this->resource['success'] ?? false) === true) {
            $data = $this->resource['data'];
            return [
                'success' => true,
                'data' => [
                    'balance' => sprintf('%.2f', (float)($data['balance'] ?? 0)),
                ],
            ];
        }

        return [
            'success' => false,
            'message' => ErrorMessage::ACCOUNT_NOT_FOUNT,
        ];
    }
}
