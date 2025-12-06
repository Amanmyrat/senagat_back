<?php

namespace App\Http\Resources;

use App\Traits\ImageUrlTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CardTypeResource extends JsonResource
{
    use ImageUrlTrait;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $locale = app()->getLocale();
        $defaultLocale = 'tk';
        $defaultAdvantages = collect($this->resource->getTranslation('advantages', $defaultLocale) ?? [])
            ->map(fn ($item) => [
                'name' => $item['name'] ?? null,
                'description' => $item['description'] ?? null,
            ])
            ->values();
        $shortestIndex = $defaultAdvantages
            ->sortBy(fn ($item) => strlen($item['name'] ?? '') + strlen($item['description'] ?? ''))
            ->keys()
            ->first();

        $advantages = collect(
            $this->resource->getTranslation('advantages', $locale) ?? []
        )->map(function ($item) {
            return [
                'name' => $item['name'] ?? null,
                'description' => $item['description'] ?? null,

            ];
        })->values();
        $shortest = $advantages[$shortestIndex] ?? null;

        return [
            'id' => $this->resource->id,
            'title' => $this->resource->getTranslation('title', $locale),
            'sub_title' => trim(($shortest['name'] ?? '').' '.($shortest['description'] ?? '')),
            'description' => $this->resource->getTranslation('text', $locale),
            'price' => $this->resource->price,
            'category' => $this->resource->category,
            'advantages' => $advantages,
            'image_url' => $this->imageUrl($this->resource->image_url),
        ];
    }
}
