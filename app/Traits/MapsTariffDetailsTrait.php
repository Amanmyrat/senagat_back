<?php

namespace App\Traits;

trait MapsTariffDetailsTrait
{
    protected function mapTariffDetail($detail): array
    {
        return [
            'title' => $detail->getTranslation('title', 'tk'),
            'number' => $detail->number,
            'items' => $this->mapTariffDetailItems($detail->details),
        ];
    }

    protected function mapTariffDetailItems(array $items): array
    {
        return collect($items)
            ->map(fn ($item) => [
                'sub_title' => $item['sub_title'] ?? null,
                'fees' => isset($item['fees'])
                    ? array_values($item['fees'])
                    : [],
            ])
            ->values()
            ->all();
    }
}
