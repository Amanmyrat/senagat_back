<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CertificateOrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'user_id' => $this->resource->user_id,
            'profile_id' => $this->resource->profile_id,
            'certificate_type_id' => $this->resource->certificate_type_id,
            'certificate_name' => optional($this->resource->certificateType)->title,
            'phone_number' => $this->resource->phone_number,
            'home_address' => $this->resource->home_address,
            'bank_branch_id' => $this->resource->bank_branch_id,
            'certificate_price' => $this->resource->certificateType->price,
            'status' => $this->resource->status,
        ];

    }
}
