<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExchangeRateResource extends JsonResource
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
            'currency' => $this->resource->getTranslation('currency', $locale),
            'purchase' => $this->resource->purchase,
            'sale' => $this->resource->sale,
            'flag' => $this->resource->flag
            ? asset('storage/'.$this->resource->flag) : null,
        ];
    }
}
