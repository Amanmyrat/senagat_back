<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApprovedCardOrderPrintController;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/anketa', function () {
    return view('questionnaire');
});

//Route::get('/approved-orders/{order}/pdf', [ApprovedCardOrderPrintController::class, 'generatePdf'])
//    ->name('approved_orders.pdf');
Route::get('/approved-card-orders/{order}/print', [ApprovedCardOrderPrintController::class, 'generatePdf'])
    ->name('approved-card-orders.print');
