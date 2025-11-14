<?php

namespace App\Http\Controllers;

use App\Models\ApprovedCardOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class ApprovedCardOrderPrintController extends Controller
{
    public function printDirect(ApprovedCardOrder $order)
    {
        $order->load(['profile', 'branch', 'cardType']);
        $html = view('questionnaire', ['orders' => collect([$order])])->render();

        $pdf = Pdf::loadHTML($html)
            ->setPaper('A5', 'portrait')
            ->setOption('defaultFont', 'DejaVu Sans');

        return $pdf->stream("anketa-{$order->id}.pdf");
    }



}





