<?php

use App\Http\Controllers\Api\AuditReportController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AwardController;
use App\Http\Controllers\Api\BeletController;
use App\Http\Controllers\Api\CardOrderController;
use App\Http\Controllers\Api\CardTypeController;
use App\Http\Controllers\Api\CertificateOrderController;
use App\Http\Controllers\Api\CertificateTypeController;
use App\Http\Controllers\Api\CharityController;
use App\Http\Controllers\Api\ClientsController;
use App\Http\Controllers\Api\ContactMessageController;
use App\Http\Controllers\Api\CreditApplicationController;
use App\Http\Controllers\Api\CreditTypeController;
use App\Http\Controllers\Api\DepositController;
use App\Http\Controllers\Api\ExchangeRateController;
use App\Http\Controllers\Api\InternationalPaymentTypesController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\MoneyTransferController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\PaymentHistoryController;
use App\Http\Controllers\Api\PaymentStatusController;
use App\Http\Controllers\Api\TariffController;
use App\Http\Controllers\Api\UserProfileController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('/request-otp', [AuthController::class, 'requestOtp']);
        Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/pre-login', [AuthController::class, 'preLogin']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::get('/user-information', [AuthController::class, 'userInfo']);
    });

    // Route::post('/check', [AuthController::class, 'checkPhoneExists']);

});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/profile', [UserProfileController::class, 'storeOrUpdate']);
    //    Route::post('/application/credit-details', [CreditApplicationController::class, 'submitCreditDetails']);
    //    Route::post('/application/work-info', [CreditApplicationController::class, 'submitWorkInfo']);
    //    Route::post('/application/branch-info', [CreditApplicationController::class, 'submitBranchInfo']);
    Route::post('/application/credit/order', [CreditApplicationController::class, 'store']);

    Route::prefix('card')->group(function () {

        Route::post('/order', [CardOrderController::class, 'store']);

    });
    Route::post('/international-payment-order', [\App\Http\Controllers\Api\InternationalPaymentOrderController::class, 'store']);
    Route::post('/certificate-order', [CertificateOrderController::class, 'store']);

    // Payment History
    Route::get('/payment-history', [PaymentHistoryController::class, 'index']);

});
// Location CRUD
Route::prefix('location')->group(function () {
    Route::get('/', [LocationController::class, 'index']);
    Route::get('/branches', [LocationController::class, 'branchLocations']);
});
// Credit CRUD
Route::prefix('credit/types')->group(function () {
    Route::get('/', [CreditTypeController::class, 'index']);
    Route::get('/{id}', [CreditTypeController::class, 'show']);
});

// Card CRUD
Route::prefix('card/types')->group(function () {
    Route::get('/', [CardTypeController::class, 'index']);
    Route::get('/{id}', [CardTypeController::class, 'show']);
});
// News
Route::prefix('news')->group(function () {
    Route::get('/', [NewsController::class, 'index']);
});
// Exchange
Route::get('/exchange-rate', [ExchangeRateController::class, 'index']);
// Certificate
Route::get('/certificate-types', [CertificateTypeController::class, 'index']);
// International Payment
Route::get('/international-payment-types', [InternationalPaymentTypesController::class, 'index']);
// Deposit
Route::prefix('deposits')->group(function () {
    Route::get('/', [DepositController::class, 'index']);
    Route::get('/{id}', [DepositController::class, 'show']);
});
// Tariff
Route::prefix('tariff')->group(function () {
    Route::get('/', [TariffController::class, 'index']);
    Route::get('/{id}', [TariffController::class, 'show']);
});
// Clients
Route::get('clients', [ClientsController::class, 'index']);
// Awards
Route::prefix('awards')->group(function () {
    Route::get('/', [AwardController::class, 'index']);
    Route::get('/{id}', [AwardController::class, 'show']);
});
// Money Transfers
Route::prefix('money-transfers')->group(function () {
    Route::get('/', [MoneyTransferController::class, 'index']);
    Route::get('/{id}', [MoneyTransferController::class, 'show']);
});
// Audit
Route::get('audit-reports', [AuditReportController::class, 'index']);
// Charity & Belet return
Route::get('/charity/return', [CharityController::class, 'return']);
Route::get('/belet/return', [BeletController::class, 'return']);

Route::middleware('optional:sanctum')->group(function () {
    // Belet CRUD
    Route::prefix('/belet')->group(function () {
        Route::get('/banks', [BeletController::class, 'banks']);
        Route::get('/balances', [BeletController::class, 'getBalanceRecommendations']);
        //        Route::get('/orders/{id}/status', [BeletController::class, 'checkStatus']);
        Route::post('/belet/check-phone', [BeletController::class, 'checkPhone']);
        Route::post('/top-up', [BeletController::class, 'topUp']);

    });
    // Charity CRUD
    Route::post('/charity', [CharityController::class, 'store']);
    //    Route::post('/charity/check-status', [CharityController::class, 'checkStatus']);
});
// CONTACT MESSAGE CRUD
Route::prefix('contact-message')->group(function () {
    Route::post('/', [ContactMessageController::class, 'store']);
});
// Payment CheckStatus CRUD
Route::get('payments/status/{orderId}', [PaymentStatusController::class, 'checkStatus']);
// Reset Password

    Route::post('reset/request', [
        AuthController::class,
        'request',
    ]);
    Route::post('reset/confirm', [
        AuthController::class,
        'confirm',
    ]);
    Route::post('reset/password', [
        AuthController::class,
        'reset',
    ]);

