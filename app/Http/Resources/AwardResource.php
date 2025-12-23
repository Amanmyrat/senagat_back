<?php

namespace App\Http\Resources;

use App\Traits\ImageUrlTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AwardResource extends JsonResource
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

        return [
            'id' => $this->resource->id,
            'title' => $this->resource->getTranslation('title', $locale),
            'sub_title' => $this->resource->getTranslation('sub_title', $locale),
            'image_url' => $this->imageUrl($this->resource->image_url),

        ];
    }
}
