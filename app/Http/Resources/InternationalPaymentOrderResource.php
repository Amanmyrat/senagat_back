<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InternationalPaymentOrderResource extends JsonResource
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
            'type' => $this->resource->type->getTranslation('title',$locale),
            'user' => [
                'first_name' => $this->user->profile->first_name ?? null,
                'last_name' => $this->user->profile->last_name ?? null,
                'passport_number' => $this->user->profile->passport_number ?? null,
                'home_address' => $this->user->profile->home_address ?? null,
            ],
            'branch_name' => $this->resource->branch->getTranslation('name',$locale),
            'uploaded_files' => collect($this->resource->uploaded_files)->mapWithKeys(function ($path, $title) {
                return [
                    $title => $path ? asset('storage/' . $path) : null
                ];
            }),
        ];

    }
}
