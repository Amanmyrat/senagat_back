<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OtpController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('users')->group(function () {
    Route::post('/otp/send', [OtpController::class, 'sendOTP']);
    Route::post('/otp/confirm', [OtpController::class, 'confirmOTP']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});
