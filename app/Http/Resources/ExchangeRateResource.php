<?php

namespace App\Http\Resources;

use App\Traits\ImageUrlTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExchangeRateResource extends JsonResource
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
            'currency' => $this->resource->getTranslation('currency', $locale),
            'purchase' => $this->resource->purchase,
            'sale' => $this->resource->sale,
            'flag' => $this->imageUrl($this->resource->flag),

        ];
    }
}
