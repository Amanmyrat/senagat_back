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
        $lang = $request->query('lang', app()->getLocale());

        return [
            'id'         => $this->resource->id,
            'type'       => $this->resource->type,
            'name'       => $this->resource->getTranslation('name', $lang),
            'address'    => $this->resource->getTranslation('address', $lang),
            'location'   => $this->resource->location,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,

        ];
    }
}
