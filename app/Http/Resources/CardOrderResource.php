<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CardOrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'user_id' => $this->resource->user_id,
            'profile_id' => $this->resource->profile_id,
            'card_type_id' => $this->resource->card_type_id,
            'phone_number' => $this->resource->phone_number,
            'bank_branch_id' => $this->resource->bank_branch_id,
            'current_address' => $this->resource->current_address,
            'work_position' => $this->resource->work_position,
            'work_phone' => $this->resource->work_phone,
            'internet_service' => (bool) $this->resource->internet_service,
            'delivery' => (bool) $this->resource->delivery,
            'email' => $this->resource->email,
        ];
    }
}
