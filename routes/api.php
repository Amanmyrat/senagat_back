<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\NewsController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('/request-otp', [AuthController::class, 'requestOtp']);
        Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/pre-login', [AuthController::class, 'preLogin']);
        Route::post('/login', [AuthController::class, 'login']);
    });

    Route::post('/check', [AuthController::class, 'checkPhoneExists']);

});

Route::prefix('location')->group(function () {
    Route::get('/', [LocationController::class, 'index']);
});

Route::prefix('News')->group(function () {
    Route::get('/', [NewsController::class, 'index']);
});
