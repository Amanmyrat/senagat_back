<?php

use App\Http\Controllers\ApprovedCardOrderPrintController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    /** @phpstan-var string $view */
    $view = 'welcome';

    return view($view);
});

Route::get('/anketa', function () {
    /** @phpstan-var string $view */
    $view = 'questionnaire';

    return view($view);
});

// Route::get('/approved-orders/{order}/pdf', [ApprovedCardOrderPrintController::class, 'generatePdf'])
//    ->name('approved_orders.pdf');

Route::get('/approved-card-orders/{order}/print', [ApprovedCardOrderPrintController::class, 'printDirect'])
    ->name('approved-card-orders.print')
    ->withoutMiddleware(['auth', 'filament']);
// Route::get('/approved-card-orders/{order}/print', [ApprovedCardOrderPrintController::class, 'printDirect'])
//    ->name('approved-card-orders.print-direct')
//    ->withoutMiddleware(['auth', 'filament']);
