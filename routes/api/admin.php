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
});
