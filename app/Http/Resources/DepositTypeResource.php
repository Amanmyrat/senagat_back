<?php

namespace App\Http\Resources;

use App\Traits\HasAdvantagesTrait;
use App\Traits\ImageUrlTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepositTypeResource extends JsonResource
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
            'sub_title' => $advantageData['sub_title'],
            'advantages' => $advantageData['advantages'],
            'image_url' => $this->imageUrl($this->resource->image_url),
            'background_color' => $this->resource->background_color,
        ];
    }
}
