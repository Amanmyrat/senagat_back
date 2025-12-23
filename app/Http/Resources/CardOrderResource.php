<?php

namespace App\Http\Resources;

use App\Traits\DateFormatTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CardOrderResource extends JsonResource
{
    use DateFormatTrait;

    public function toArray(Request $request): array
    {
        $locale = app()->getLocale();

        return [
            'id' => $this->resource->id,
            'card_title' => optional($this->resource->cardType)->getTranslation('title', $locale),
            'card_price' => $this->resource->cardType->price,
            'bank_branch' => optional($this->resource->branch)->getTranslation('name', $locale),
            'work_position' => $this->resource->work_position,
            'work_phone' => $this->resource->work_phone,
            'internet_service' => (bool) $this->resource->internet_service,
            'delivery' => (bool) $this->resource->delivery,
            'email' => $this->resource->email,
            'status' => $this->resource->status,
            'created_at' => $this->formatDateLocalized($this->resource->created_at),
        ];
    }
}
