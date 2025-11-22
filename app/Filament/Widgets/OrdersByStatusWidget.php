<?php

namespace App\Filament\Widgets;

use App\Models\CardOrder;
use App\Models\CertificateOrder;
use App\Models\CreditApplication;
use Filament\Widgets\ChartWidget;

class OrdersByStatusWidget extends ChartWidget
{
    protected static ?int $sort = 4;

    public function getHeading(): ?string
    {
        return __('resource.orders_distribution_by_status');
    }

    protected function getData(): array
    {
        $pendingCards = CardOrder::where('status', 'pending')->count();
        $approvedCards = CardOrder::where('status', 'approved')->count();
        $rejectedCards = CardOrder::where('status', 'rejected')->count();

        $pendingLoans = CreditApplication::where('status', 'pending')->count();
        $approvedLoans = CreditApplication::where('status', 'approved')->count();
        $rejectedLoans = CreditApplication::where('status', 'rejected')->count();

        $pendingCerts = CertificateOrder::where('status', 'pending')->count();
        $approvedCerts = CertificateOrder::where('status', 'approved')->count();
        $rejectedCerts = CertificateOrder::where('status', 'rejected')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Orders by Status',
                    'data' => [
                        $pendingCards + $pendingLoans + $pendingCerts,
                        $approvedCards + $approvedLoans + $approvedCerts,
                        $rejectedCards + $rejectedLoans + $rejectedCerts,
                    ],
                    'backgroundColor' => [
                        'rgba(251, 191, 36, 0.7)',  // Warning - Pending
                        'rgba(34, 197, 94, 0.7)',   // Success - Approved
                        'rgba(239, 68, 68, 0.7)',   // Danger - Rejected
                    ],
                ],
            ],
            'labels' => [
                __('resource.pending'),
                __('resource.approved'),
                __('resource.rejected'),
            ],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
