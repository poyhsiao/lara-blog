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
 * User
 */
Route::group(['prefix'=> 'user', 'name'=> 'user.'], function () {
    /**
     * Get myself information
     */
    Route::get('me', [App\Http\Controllers\UserController::class, 'me'])
      ->name('me');

    /**
     * Change the authenticated user's password
     */
    Route::patch('password', [App\Http\Controllers\UserController::class, 'changePassword'])
      ->name('changePassword');

    /**
     * Update the authenticated user's profile information
     */
    Route::patch('profile', [App\Http\Controllers\UserController::class, 'updateProfile'])
      ->name('updateProfile');
});
