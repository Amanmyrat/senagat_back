<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OtpController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->group(function () {
    Route::post('/otp/send', [OtpController::class, 'sendOTP']);
    Route::post('/otp/confirm', [OtpController::class, 'confirmOTP']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});
