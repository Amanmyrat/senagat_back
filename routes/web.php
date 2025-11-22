<?php

use App\Http\Controllers\ApprovedCardOrderPrintController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/anketa', function () {
    return view('questionnaire');
});

// Route::get('/approved-orders/{order}/pdf', [ApprovedCardOrderPrintController::class, 'generatePdf'])
//    ->name('approved_orders.pdf');

Route::get('/approved-card-orders/{order}/print', [ApprovedCardOrderPrintController::class, 'printDirect'])
    ->name('approved-card-orders.print')
    ->withoutMiddleware(['auth', 'filament']);
// Route::get('/approved-card-orders/{order}/print', [ApprovedCardOrderPrintController::class, 'printDirect'])
//    ->name('approved-card-orders.print-direct')
//    ->withoutMiddleware(['auth', 'filament']);
