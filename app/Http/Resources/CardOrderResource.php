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
            'home_phone_number' => $this->resource->home_phone_number,
            'bank_branch' => $this->resource->bank_branch,

        ];
    }
}
