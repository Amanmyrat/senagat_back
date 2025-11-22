<?php

use App\Http\Controllers\Api\AuditReportController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AwardController;
use App\Http\Controllers\Api\CardOrderController;
use App\Http\Controllers\Api\CardTypeController;
use App\Http\Controllers\Api\CertificateOrderController;
use App\Http\Controllers\Api\CertificateTypeController;
use App\Http\Controllers\Api\ClientsController;
use App\Http\Controllers\Api\ContactMessageController;
use App\Http\Controllers\Api\CreditApplicationController;
use App\Http\Controllers\Api\CreditTypeController;
use App\Http\Controllers\Api\DepositController;
use App\Http\Controllers\Api\ExchangeRateController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\MoneyTransferController;
use App\Http\Controllers\Api\NewsController;
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

    Route::post('/check', [AuthController::class, 'checkPhoneExists']);

});
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/profile', [UserProfileController::class, 'storeOrUpdate']);
    //    Route::post('/application/credit-details', [CreditApplicationController::class, 'submitCreditDetails']);
    //    Route::post('/application/work-info', [CreditApplicationController::class, 'submitWorkInfo']);
    //    Route::post('/application/branch-info', [CreditApplicationController::class, 'submitBranchInfo']);
    Route::post('/application/credit/order', [CreditApplicationController::class, 'store']);

    Route::prefix('contact-message')->group(function () {
        Route::post('/', [ContactMessageController::class, 'store']);
    });
    Route::prefix('card')->group(function () {

        Route::post('/order', [CardOrderController::class, 'store']);

    });

    Route::post('/certificate-order', [CertificateOrderController::class, 'store']);

});
Route::prefix('location')->group(function () {
    Route::get('/', [LocationController::class, 'index']);
    Route::get('/branches', [LocationController::class, 'branchLocations']);
});
Route::prefix('credit/types')->group(function () {
    Route::get('/', [CreditTypeController::class, 'index']);
    Route::get('/{id}', [CreditTypeController::class, 'show']);
});

Route::prefix('card/types')->group(function () {
    Route::get('/', [CardTypeController::class, 'index']);
    Route::get('/{id}', [CardTypeController::class, 'show']);
});

Route::prefix('news')->group(function () {
    Route::get('/', [NewsController::class, 'index']);
});
Route::get('/exchange-rate', [ExchangeRateController::class, 'index']);
Route::get('/certificate-types', [CertificateTypeController::class, 'index']);
Route::prefix('deposits')->group(function () {
    Route::get('/', [DepositController::class, 'index']);
    Route::get('/{id}', [DepositController::class, 'show']);
});
Route::prefix('tariff')->group(function () {
    Route::get('/', [TariffController::class, 'index']);
    Route::get('/{id}', [TariffController::class, 'show']);
});
Route::get('clients', [ClientsController::class, 'index']);

Route::prefix('awards')->group(function () {
    Route::get('/', [AwardController::class, 'index']);
    Route::get('/{id}', [AwardController::class, 'show']);
});

Route::prefix('money-transfers')->group(function () {
    Route::get('/', [MoneyTransferController::class, 'index']);
    Route::get('/{id}', [MoneyTransferController::class, 'show']);
});

Route::get('audit-reports', [AuditReportController::class, 'index']);
