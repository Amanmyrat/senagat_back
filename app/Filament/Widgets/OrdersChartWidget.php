<?php

namespace App\Filament\Widgets;

use App\Models\CardOrder;
use App\Models\CertificateOrder;
use App\Models\CreditApplication;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class OrdersChartWidget extends ChartWidget
{
    protected static ?int $sort = 2;

    public function getHeading(): ?string
    {
        return __('resource.orders_overview_last_7_days');
    }

    protected function getData(): array
    {
        $data = $this->getOrdersPerDay();

        return [
            'datasets' => [
                [
                    'label' => __('resource.card_orders'),
                    'data' => $data['cards'],
                    'backgroundColor' => 'rgba(59, 130, 246, 0.5)',
                    'borderColor' => 'rgb(59, 130, 246)',
                ],
                [
                    'label' => __('resource.loan_applications'),
                    'data' => $data['loans'],
                    'backgroundColor' => 'rgba(16, 185, 129, 0.5)',
                    'borderColor' => 'rgb(16, 185, 129)',
                ],
                [
                    'label' => __('resource.certificate_orders'),
                    'data' => $data['certificates'],
                    'backgroundColor' => 'rgba(249, 115, 22, 0.5)',
                    'borderColor' => 'rgb(249, 115, 22)',
                ],
            ],
            'labels' => $data['labels'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    private function getOrdersPerDay(): array
    {
        $days = 7;
        $labels = [];
        $cards = [];
        $loans = [];
        $certificates = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels[] = $date->format('M d');

            $cards[] = CardOrder::whereDate('created_at', $date)->count();
            $loans[] = CreditApplication::whereDate('created_at', $date)->count();
            $certificates[] = CertificateOrder::whereDate('created_at', $date)->count();
        }

        return [
            'labels' => $labels,
            'cards' => $cards,
            'loans' => $loans,
            'certificates' => $certificates,
        ];
    }
}
