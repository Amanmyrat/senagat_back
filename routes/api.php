<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/register/request-otp', [RegisterController::class, 'registerRequestOtp']);
Route::post('/register/verify-otp', [RegisterController::class, 'registerVerifyOtp']);
Route::post('/register/set-password', [RegisterController::class, 'registerSetPassword']);
Route::post('/login/login-request-otp', [LoginController::class, 'loginRequestOtp']);
Route::post('/login/verify-otp', [LoginController::class, 'loginVerifyOtp']);
Route::post('/login', [LoginController::class, 'loginWithPassword']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout']);
});
