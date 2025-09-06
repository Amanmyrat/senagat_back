<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
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
            'first_name' => $this->resource->first_name,
            'last_name' => $this->resource->last_name,
            'middle_name' => $this->resource->middle_name,
            'birth_date' => $this->resource->birth_date ? $this->resource->birth_date->format('d-m-Y') : null,
            'passport_number' => $this->resource->passport_number,
            'gender' => $this->resource->gender,
            'issued_date' => $this->resource->issued_date ? $this->resource->issued_date->format('d-m-Y') : null,
            'issued_by' => $this->resource->issued_by,
            'scan_passport' => $this->resource->scan_passport ? asset('storage/'.$this->resource->scan_passport) : null,
            'approved' => $this->resource->approved,

        ];
    }
}
