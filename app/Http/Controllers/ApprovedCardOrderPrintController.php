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
            'orders' => collect([$order])
        ])->render();
        $pdf = Pdf::loadHTML($html)
            ->setPaper('A4', 'portrait')
            ->setOption('defaultFont', 'LiberationSerif')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true);

        return $pdf->stream('anketa.pdf');
    }
}
