<?php

use Illuminate\Support\Facades\Route;

/**
 * User
 */
Route::group(['prefix' => 'user', 'name' => 'user.'], function () {
  Route::get('detail', [App\Http\Controllers\AdminController::class, 'getUserDetail'])
    ->name('getDetail');

  Route::get('all', [App\Http\Controllers\AdminController::class, 'getAllUsers'])
    ->name('getAll');

  Route::get('inactive', [App\Http\Controllers\AdminController::class, 'getInactiveUsers'])
    ->name('getInactive');

  Route::get('invalid', [App\Http\Controllers\AdminController::class, 'getNonValidatedUsers'])
    ->name('getNonValidated');

  Route::get('trashed', [App\Http\Controllers\AdminController::class, 'getAllTrashedUsers'])
    ->name('getTrashed');
});
