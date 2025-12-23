<?php

namespace App\Traits;

trait HasAdvantagesTrait
{
    protected function resolveAdvantages($model, string $locale, string $defaultLocale = 'tk'): array
    {
        $defaultAdvantages = collect(
            $model->getTranslation('advantages', $defaultLocale) ?? []
        )->map(fn ($item) => [
            'name' => $item['name'] ?? null,
            'description' => $item['description'] ?? null,
        ])->values();

        $shortestIndex = $defaultAdvantages
            ->sortBy(fn ($item) => strlen($item['name'] ?? '') + strlen($item['description'] ?? '')
            )
            ->keys()
            ->first();

        $advantages = collect(
            $model->getTranslation('advantages', $locale) ?? []
        )->map(fn ($item) => [
            'name' => $item['name'] ?? null,
            'description' => $item['description'] ?? null,
        ])->values();

        $shortest = $advantages[$shortestIndex] ?? null;

        return [
            'advantages' => $advantages,
            'sub_title' => trim(
                ($shortest['name'] ?? '').' '.($shortest['description'] ?? '')
            ),
        ];
    }
}
