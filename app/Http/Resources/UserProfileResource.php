<?php

namespace App\Http\Resources;

use App\Traits\ImageUrlTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{
    use ImageUrlTrait;
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
            'issued_date' => $this->resource->issued_date ? $this->resource->issued_date->format('d-m-Y') : null,
            'issued_by' => $this->resource->issued_by,
            'citizenship' => $this->resource->citizenship,
            'home_phone' => $this->resource->home_phone,
            'home_address' => $this->resource->home_address,
            'scan_passport' =>   $this->imageUrl($this->resource->scan_passport),

        ];
    }
}
