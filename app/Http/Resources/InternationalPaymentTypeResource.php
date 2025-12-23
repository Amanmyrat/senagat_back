<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InternationalPaymentTypeResource extends JsonResource
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
            'required_files' => array_values($this->resource->getTranslation('required_files', $locale) ?? []),
        ];
    }
}
