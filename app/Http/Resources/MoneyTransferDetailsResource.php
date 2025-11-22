<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MoneyTransferDetailsResource extends JsonResource
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
            'sub_title' => $this->resource->getTranslation('sub_title', $locale),
            'main_title' => $this->resource->getTranslation('main_title', $locale),
            'description' => $this->resource->getTranslation('description', $locale),
            'header_text' => $this->resource->getTranslation('header_text', $locale),
            'footer_text' => $this->resource->getTranslation('footer_text', $locale),
            'advantages' => collect($this->resource->getTranslation('advantages', $locale) ?? [])
                ->map(function ($item) {
                    return [
                        'title' => $item['title'] ?? null,
                    ];
                })
                ->values(),
            'tariff_details' => collect($this->resource->getTranslation('tariff_details', $locale) ?? [])
                ->map(function ($table) {
                    return [
                        'table_title' => $table['table_title'] ?? null,
                        'rows' => collect($table['rows'] ?? [])
                            ->map(function ($row) {
                                return [
                                    'service_type' => $row['service_type'] ?? null,
                                    'service_cost' => $row['service_cost'] ?? null,
                                    'vat' => $row['vat'] ?? null,
                                    'total_payment' => $row['total_payment'] ?? null,
                                ];
                            })
                            ->values(),
                    ];
                })
                ->values(),
            'image_url' => $this->resource->image_url
                ? asset('storage/'.$this->resource->image_url)
                : null,
            'background_color' => $this->resource->background_color,
        ];
    }
}
