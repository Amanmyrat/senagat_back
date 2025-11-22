<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            'title' => $this->resource->getTranslation('title', $locale),
            'company_type' => $this->resource->getTranslation('company_type', $locale),
            'description' => $this->resource->getTranslation('description', $locale),
            'image_url' => asset('storage/'.$this->resource->image_url),

        ];
    }
}
