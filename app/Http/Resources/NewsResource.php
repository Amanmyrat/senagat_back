<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
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
            'description' => strip_tags($this->resource->getTranslation('description', $locale)),
            'published_at' => Carbon::parse($this->resource->published_at)
                ->locale($locale)
                ->translatedFormat('d F Y'),

        ];
    }
}
