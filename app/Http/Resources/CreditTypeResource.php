<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CreditTypeResource extends JsonResource
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
            'name' => $this->resource->getTranslation('name', $locale),
            'description' => $this->resource->getTranslation('description', $locale),
            'term' => $this->resource->term,
            'min_amount' => $this->resource->min_amount,
            'max_amount' => $this->resource->max_amount,
            'interest' => $this->resource->interest,
            'background_color'=>$this->resource->background_color,
            'image_url' => $this->resource->image_url
                ? asset('storage/'.$this->resource->image_url) : null,
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
