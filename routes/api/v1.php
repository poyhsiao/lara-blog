<?php

use Illuminate\Support\Facades\Route;

/**
 * Auth
 */
Route::group([], function () {
    Route::post('/register', [App\Http\Controllers\JWTAuthController::class, 'register'])
      ->name('register');

    Route::post('/login', [App\Http\Controllers\JWTAuthController::class, 'login'])
      ->name('login');

    Route::middleware(['jwt', 'verified'])->group(function () {
        Route::get('/me', [App\Http\Controllers\JWTAuthController::class, 'getMe'])
          ->name('me');

        Route::post('/logout', [App\Http\Controllers\JWTAuthController::class, 'logout'])
          ->name('logout');
    });
});

/**
 * Admin
 */
