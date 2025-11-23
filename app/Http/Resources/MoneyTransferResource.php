<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MoneyTransferResource extends JsonResource
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
            'main_title' => $this->resource->getTranslation('main_title', $locale),
            'sub_title' => $this->resource->getTranslation('sub_title', $locale),
            'image_url' => $this->resource->image_url
                ? asset('storage/'.$this->resource->image_url)
                : null,
            'background_color' => $this->resource->background_color,
        ];
    }
}
