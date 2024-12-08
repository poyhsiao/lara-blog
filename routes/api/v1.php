<?php

use Illuminate\Support\Facades\Route;

Route::post('/register', [App\Http\Controllers\JWTAuthController::class, 'register'])
  ->name('register');

Route::post('/login', [App\Http\Controllers\JWTAuthController::class, 'login'])
  ->name('login');

Route::middleware(['jwt', 'verified'])->group(function () {
  Route::get('/me', [App\Http\Controllers\JWTAuthController::class, 'getMe'])
    ->name('me');

  Route::patch('/refresh-token', [App\Http\Controllers\JWTAuthController::class, 'refreshToken'])
    ->name('refreshToken');

  Route::post('/logout', [App\Http\Controllers\JWTAuthController::class, 'logout'])
    ->name('logout');
});
