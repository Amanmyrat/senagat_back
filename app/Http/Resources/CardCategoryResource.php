<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CardCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'cardTypes' => $this->resource->cardTypes->map(function ($cardTypes) {
                return [
                    'id' => $cardTypes->id,
                    'title' => $cardTypes->title,
                    'image_path' => $cardTypes->image_path,
                    'advantages' => array_values($cardTypes->advantages ?? []),

                ];
            }),
            // 'name' => $this->resource->getTranslation('name', $locale),

        ];
    }
}
