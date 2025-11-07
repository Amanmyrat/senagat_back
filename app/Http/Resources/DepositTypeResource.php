<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepositTypeResource extends JsonResource
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
            'advantages' => collect(
                $this->resource->getTranslation('advantages', $locale) ?? []
            )->map(function ($item) {
                return [
                    'name' => $item['name'] ?? null,
                    'description' => $item['description'] ?? null,
                ];
            })->values(),
            'image_url' => $this->resource->image_url
                ? asset('storage/'.$this->resource->image_url) : null,
            'background_color'=>$this->resource->background_color,
        ];
    }
}
