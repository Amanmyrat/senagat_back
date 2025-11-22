<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TariffDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $items = $this->resource->details->map(function ($detail) {
            $detailItems = collect($detail->details)->map(function ($item) {
                return [
                    'sub_title' => $item['sub_title'] ?? null,
                    'fees' => isset($item['fees']) ? array_values($item['fees']) : [],
                ];
            })->values();

            return [
                'title' => $detail->title ?: null,
                'number' => $detail->number,
                'items' => $detailItems,
            ];
        });
        $sortedItems = $items->sort(function ($a, $b) {
            $aParts = array_map('intval', explode('.', $a['number']));
            $bParts = array_map('intval', explode('.', $b['number']));
            $len = max(count($aParts), count($bParts));

            for ($i = 0; $i < $len; $i++) {
                $aVal = $aParts[$i] ?? 0;
                $bVal = $bParts[$i] ?? 0;
                if ($aVal !== $bVal) {
                    return $aVal <=> $bVal;
                }
            }

            return 0;
        })->values();

        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'items' => $sortedItems,
        ];
    }
}
