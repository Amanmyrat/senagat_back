<?php

namespace App\Http\Controllers;

use App\Models\ApprovedCardOrder;
use Barryvdh\DomPDF\Facade\Pdf;

class ApprovedCardOrderPrintController extends Controller
{
    public function printDirect(ApprovedCardOrder $order)
    {
        $order->load(['profile', 'branch', 'cardType']);
        /** @var string $view */
        $view = 'questionnaire';
        $html = view($view, ['orders' => collect([$order])])->render();

        $pdf = Pdf::loadHTML($html)
            ->setPaper('A4', 'portrait')
            ->setOption('defaultFont', 'DejaVu Sans');

        return $pdf->stream("anketa-{$order->id}.pdf");
    }
}
