<?php

namespace App\Http\Resources;

use App\Traits\HasMoneyTransferMappingsTrait;
use App\Traits\ImageUrlTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MoneyTransferDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    use HasMoneyTransferMappingsTrait, ImageUrlTrait;
    public function toArray(Request $request): array
    {
        $locale = app()->getLocale();

        return [
            'id' => $this->resource->id,
            'title' => $this->resource->getTranslation('title', $locale),
            'sub_title' => $this->resource->getTranslation('sub_title', $locale),
            'main_title' => $this->resource->getTranslation('main_title', $locale),
            'description' => $this->resource->getTranslation('description', $locale),
            'header_text' => $this->resource->getTranslation('header_text', $locale),
            'footer_text' => $this->resource->getTranslation('footer_text', $locale),
            'advantages' => $this->mapAdvantages(
                $this->resource->getTranslation('advantages', $locale) ?? []
            ),

            'tariff_details' => $this->mapTariffDetails(
                $this->resource->getTranslation('tariff_details', $locale) ?? []
            ),
            $this->imageUrl($this->resource->image_url),
            'background_color' => $this->resource->background_color,
        ];
    }
}
