<?php

use App\Http\Controllers\ApprovedCardOrderPrintController;
use App\Http\Controllers\OrderPdfController;
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


Route::get('/approved-card-orders/{order}/print-view', [ApprovedCardOrderPrintController::class, 'printView'])
    ->name('approved-card-orders.print-view')
    ->middleware('web');
Route::get('/card-orders/{record}/pdf', [OrderPdfController::class, 'card'])
    ->name('card-orders.pdf');
Route::get('/credit-orders/{record}/pdf', [OrderPdfController::class, 'credit'])
    ->name('credit-orders.pdf');
Route::get('/certificate/{id}/pdf', [OrderPdfController::class, 'certificate'])->name('certificate.pdf');
Route::get('/profile/{id}/pdf', [OrderPdfController::class, 'profile'])->name('profile.pdf');
Route::get('/profile/{id}/pending-pdf', [OrderPdfController::class, 'pendingProfile'])
    ->name('pendingProfile.pdf');
Route::get('/international-payment-orders/{record}/pdf', [OrderPdfController::class, 'internationalPayment'])
    ->name('international-payments.pdf');
