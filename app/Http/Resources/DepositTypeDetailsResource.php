<?php

namespace App\Http\Resources;

use App\Traits\HasAdvantagesTrait;
use App\Traits\ImageUrlTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepositTypeDetailsResource extends JsonResource
{
    use HasAdvantagesTrait,ImageUrlTrait;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $locale = app()->getLocale();
        $advantageData = $this->resolveAdvantages($this->resource, $locale);

        return [
            'id' => $this->resource->id,
            'title' => $this->resource->getTranslation('title', $locale),
            'description' => $this->resource->getTranslation('description', $locale),
            'sub_title' => $advantageData['sub_title'],
            'advantages' => $advantageData['advantages'],
            'details' => collect($this->resource->getTranslation('details', $locale) ?? [])
                ->map(function ($item) {
                    return [
                        'description' => $item['description'] ?? null,
                    ];
                })
                ->values(),
            'image_url' => $this->imageUrl($this->resource->image_url),
            'background_color' => $this->resource->background_color,
        ];
    }
}
