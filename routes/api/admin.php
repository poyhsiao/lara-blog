<?php

use Illuminate\Support\Facades\Route;

/**
 * User
 */
Route::group(['prefix' => 'user', 'name' => 'user.'], function () {
    /**
     * Get user detail by email, name, or id
     */
    Route::get('detail', [App\Http\Controllers\AdminController::class, 'getUserDetail'])
      ->name('getDetail');

    /**
     * Get all users data (paginated)
     */
    Route::get('all', [App\Http\Controllers\AdminController::class, 'getAllUsers'])
      ->name('getAll');

    /**
     * Get all inactive users (paginated)
     */
    Route::get('inactive', [App\Http\Controllers\AdminController::class, 'getInactiveUsers'])
      ->name('getInactive');

    /**
     * Get all invalid users (paginated)
     */
    Route::get('invalid', [App\Http\Controllers\AdminController::class, 'getNonValidatedUsers'])
      ->name('getNonValidated');

    /**
     * Get all soft-deleted user (paginated)
     */
    Route::get('trashed', [App\Http\Controllers\AdminController::class, 'getAllTrashedUsers'])
      ->name('getTrashed');

    /**
     * Update user's profile
     */
    Route::patch('profile', [App\Http\Controllers\AdminController::class, 'updateUserProfile'])
      ->name('updateProfile');

    /**
     * Update user's password
     */
    Route::patch('password', [App\Http\Controllers\AdminController::class, 'setPassword'])
      ->name('setPassword');

    /**
     * Set user's verify or not
     */
    Route::patch('verify', [App\Http\Controllers\AdminController::class, 'setVerify'])
      ->name('setVerify');

    /**
     * Set user's active or not
     */
    Route::patch('active', [App\Http\Controllers\AdminController::class,'setActive'])
      ->name('setActive');

    /**
     * Soft-delete or restore user
     */
    Route::patch('trash', [App\Http\Controllers\AdminController::class,'setTrash'])
      ->name('setTrash');
});
