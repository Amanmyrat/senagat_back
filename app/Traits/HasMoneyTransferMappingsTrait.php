<?php

namespace App\Traits;

trait HasMoneyTransferMappingsTrait
{
    protected function mapAdvantages(array $advantages): array
    {
        return collect($advantages)
            ->map(fn ($item) => [
                'title' => $item['title'] ?? null,
            ])
            ->values()
            ->all();
    }

    protected function mapTariffDetails(array $tariffs): array
    {
        return collect($tariffs)
            ->map(fn ($table) => [
                'table_title' => $table['table_title'] ?? null,
                'rows' => collect($table['rows'] ?? [])
                    ->map(fn ($row) => [
                        'service_type' => $row['service_type'] ?? null,
                        'service_cost' => $row['service_cost'] ?? null,
                        'vat' => $row['vat'] ?? null,
                        'total_payment' => $row['total_payment'] ?? null,
                    ])
                    ->values()
                    ->all(),
            ])
            ->values()
            ->all();
    }
}
