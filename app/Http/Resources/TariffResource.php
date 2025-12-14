<?php

namespace App\Http\Resources;

use App\Traits\MapsTariffDetailsTrait;
use App\Traits\SortsByNumberTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TariffResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    use SortsByNumberTrait, MapsTariffDetailsTrait;
    public function toArray(Request $request): array
    {
        $items = $this->resource->details
            ->map(fn ($detail) => $this->mapTariffDetail($detail));

        return [
            'id' => $this->resource->id,
            'title' => $this->resource->getTranslation('title', 'tk'),
            'items' => $this->sortByDottedNumber($items),
        ];
    }

}
