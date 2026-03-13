<?php

namespace App\Http\Resources;

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
            return [
                'success' => true,
                'data' => $this->resource['data'],
            ];
        }

        return [
            'success' => false,
            'error' => $this->resource['error'],
        ];
    }
}
