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
        $hours = $this->resource->getTranslation('hours', $locale);

        return [
            'id' => $this->resource->id,
            'type' => $this->resource->type,
            'name' => $this->resource->getTranslation('name', $locale),
            'address' => $this->resource->getTranslation('address', $locale),
            'location' => $this->resource->location,
            'phone_number' => $this->resource->phone_number,
            'fax_number' => $this->resource->fax_number,
            'help_desk_number' => $this->resource->home_number,
            'offers_credit' => $this->resource->offers_credit,
            'offers_card' => $this->resource->offers_card,
            'offers_certificate' => $this->resource->offers_certificate,
            'working_hours' => array_values($hours ?? []),

        ];
    }
}
