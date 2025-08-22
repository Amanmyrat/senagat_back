<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $locale = app()->getLocale();

        return [
            'id' => $this->resource->id,
            'type' => $this->resource->type,
            'name' => $this->resource->getTranslation('name', $locale),
            'address' => $this->resource->getTranslation('address', $locale),
            'location' => $this->resource->location,

        ];
    }
}
