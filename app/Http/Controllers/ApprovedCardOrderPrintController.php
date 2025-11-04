<?php

namespace App\Http\Controllers;

use App\Models\ApprovedCardOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;

class ApprovedCardOrderPrintController extends Controller
{
    public function generatePdf(ApprovedCardOrder $order)
    {

        $order->load(['profile', 'branch', 'cardType']);
        $html = view('questionnaire', [
            'orders' => collect([$order]),
        ])->render();
        $pdf = Pdf::loadHTML($html)
            ->setPaper('A4', 'portrait')
            ->setOption('defaultFont', 'LiberationSerif')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true);

        return $pdf->download('anketa.pdf');
    }

    public function printDirect(ApprovedCardOrder $order)
    {
        $order->load(['profile', 'branch', 'cardType']);

        // questionnaire.blade.php view’ını PDF olarak render et
        $html = view('approved-card-orders.questionnaire', [
            'orders' => collect([$order]),
        ])->render();

        $pdf = Pdf::loadHTML($html)
            ->setPaper('A4', 'portrait')
            ->setOption('defaultFont', 'LiberationSerif')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true);

        $base64 = base64_encode($pdf->output());

        return view('approved-card-orders.print-direct', [
            'base64' => $base64,
        ]);
    }

    public function printPdfDirect(ApprovedCardOrder $order)
    {
        $order->load(['profile', 'branch', 'cardType']);

        $html = view('questionnaire', ['orders' => collect([$order])])->render();

        $pdf = Pdf::loadHTML($html)
            ->setPaper('A4', 'portrait')
            ->setOption('defaultFont', 'LiberationSerif')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true);

        // PDF’i base64 olarak dön
        $base64 = base64_encode($pdf->output());

        return response()->json(['base64' => $base64]);
    }
}
