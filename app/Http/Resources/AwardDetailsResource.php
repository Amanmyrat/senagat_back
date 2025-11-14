<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class AwardDetailsResource extends JsonResource
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
            'sub_title'=>$this->resource->getTranslation('sub_title', $locale),
            'image_url' => asset('storage/' . $this->resource->image_url),
           'description'=>$this->resource->getTranslation('description', $locale),
            'description_images' => $this->resource->description_images
                ? collect($this->resource->description_images)
                    ->map(fn ($img) => asset('storage/' . $img))
                    ->toArray()
                : [],


        ];
    }
}
