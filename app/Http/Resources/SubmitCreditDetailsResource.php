<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubmitCreditDetailsResource extends JsonResource
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
            'user_id' => $this->resource->user_id,
            'credit_id' => $this->resource->credit_id,
            'years' => $this->resource->years,
            'amount' => $this->resource->amount,
            'interest' => $this->resource->interest,
            'profile_id' => $this->resource->profile_id,
        ];
    }
}
