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
            'amount' => $this->resource->amount,
            'interest' => $this->resource->interest,
            'requirement_groups' => $this->resource->requirementGroups->map(function ($group) {
                return [
                    'title' => $group->title,
                    'categories' => $group->categories->map(function ($category) {
                        return [
                            'name' => $category->name,
                            'items' => $category->items->pluck('name'),
                        ];
                    }),
                ];
            }),

        ];
    }
}
