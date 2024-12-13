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
Route::group(['prefix' => 'user', 'name' => 'user.'], function () {
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

    Route::get('posts', [App\Http\Controllers\UserController::class, 'getPosts'])
      ->name('getPosts');
});

/**
 * Post
 */
Route::group(['prefix' => 'post', 'name' => 'post.'], function () {
    /**
     * Create a new post
     */
    Route::post('', [App\Http\Controllers\PostController::class, 'create'])
    ->name('create');

    Route::get('/id/{id}', [App\Http\Controllers\PostController::class, 'getPostById'])
    ->name('getPostById');

    Route::get('name/{name}', [App\Http\Controllers\PostController::class, 'getPostByName'])
    ->name('getPostByName');

    Route::patch('{id}', [App\Http\Controllers\PostController::class, 'update'])
    ->name('update');

    Route::delete('{id}', [App\Http\Controllers\PostController::class, 'delete'])
    ->name('delete');
});

/**
 * Category
 */
Route::group(['prefix'=> 'category','name'=> 'category.'], function () {
    /**
     * Get all categories
     */
    Route::get('', [App\Http\Controllers\CategoryController::class, 'index'])
    ->name('index');

    /**
     * Get a category by ID
     */
    Route::get('{id}', [App\Http\Controllers\CategoryController::class, 'getById'])
    ->name('getById');

    /**
     * Get all trashed categories
     */
    Route::get('trashed', [App\Http\Controllers\CategoryController::class,'indexTrashed'])
    ->name('getTrashed');

    /**
     * Create a new category
     */
    Route::post('', [App\Http\Controllers\CategoryController::class, 'create'])
    ->name('create');

    /**
     * Update a category
     */
    Route::patch('{id}', [App\Http\Controllers\CategoryController::class, 'update'])
    ->name('update');

    /**
     * Delete a category
     */
    Route::delete('{id}', [App\Http\Controllers\CategoryController::class, 'delete'])
    ->name('delete');

    /**
     * Restore a deleted category
     */
    Route::patch('/restore/{id}', [App\Http\Controllers\CategoryController::class, 'restore'])
    ->name('restore');
});