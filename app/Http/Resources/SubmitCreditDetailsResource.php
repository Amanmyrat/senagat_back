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
            'profile_id' => $this->resource->profile_id,
            'credit_id' => $this->resource->credit_id,
            'credit_name' => optional($this->resource->credit)->name,
            'term' => $this->resource->term,
            'amount' => $this->resource->amount,
            'interest' => $this->resource->interest,
            'monthly_payment' => $this->resource->monthly_payment,
            'status'=>$this->resource->status

        ];
    }
}
