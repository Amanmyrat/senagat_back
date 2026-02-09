<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'type' => $this->resource->type,
            'status' => $this->resource->status,
            'amount' => $this->resource->amount,

            'payment_target' => $this->resource->payment_target
                ? [
                    'type' => $this->payment_target['type'] ?? null,
                    'value' => $this->payment_target['value'] ?? null,
                ]
                : null,

            'created_at' => $this->resource->created_at->format('d/m/Y'),

        ];
    }
}
