<?php

namespace App\Http\Resources;

use App\Traits\ImageUrlTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CreditTypeResource extends JsonResource
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
            'title' => $this->resource->getTranslation('name', $locale),
            'description' => $this->resource->getTranslation('description', $locale),
            'can_offer_online' => $this->resource->can_offer_online,
            'category' => $this->resource->category,
            'term' => $this->resource->term ?: null,
            'min_amount' => $this->resource->min_amount ?: null,
            'max_amount' => $this->resource->max_amount ?: null,
            'term_text' => $this->resource->getTranslation('term_text', $locale) ?: null,
            'amount_text' => $this->resource->getTranslation('amount_text', $locale) ?: null,
            'interest' => $this->resource->interest,
            'background_color' => $this->resource->background_color,
            'image_url' => $this->imageUrl($this->resource->image_url),

            'requirements_description' => $this->resource->getTranslation('requirements_description', $locale) ?: null,
            'requirements' => collect($this->resource->getTranslation('requirements', $locale) ?? [])
                ->map(function ($item) {
                    return [
                        'title' => $item['title'] ?? null,
                        'type' => $item['type'] ?? null,
                        'rules' => array_values(
                            collect($item['rules'] ?? [])
                                ->map(function ($rule) {
                                    return [
                                        'rule' => $rule['rule'] ?? null,
                                        'subrules' => array_values($rule['subrules'] ?? []),
                                    ];
                                })
                                ->toArray()
                        ),
                    ];
                })->values(),

        ];
    }
}
