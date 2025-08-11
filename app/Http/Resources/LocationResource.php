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
            'id' => $this->id,
            'type' => $this->type,
            'name' => $this->getTranslation('name', $lang),
            'address' => $this->getTranslation('address', $lang),
            'location' => $this->location,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}
