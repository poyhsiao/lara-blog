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

    /**
     * Get all posts of the authenticated user
     */
    Route::get('posts', [App\Http\Controllers\UserController::class, 'getPosts'])
      ->name('getPosts');

    /**
     * Get a user by ID with filter (posts, comments, emotions, emotionUsers)
     */
    Route::get('id/{id}', [App\Http\Controllers\UserController::class, 'getById'])
      ->name('getById');

    /**
     * Get all comments of the authenticated user
     */
    Route::get('comments', [App\Http\Controllers\UserController::class, 'getComments'])
    ->name('getComments');

    /**
     * Get all emotions of the authenticated user
     */
    Route::get('emotions', [App\Http\Controllers\UserController::class, 'getEmotions'])
    ->name('getEmotions');

    /**
     * Get all emotions of the authenticated user that the user has received
     */
    Route::get('emotions/me', [App\Http\Controllers\UserController::class, 'getEmotionsToMe'])
    ->name('getEmotionsToMe');
});

/**
 * Post
 */
Route::group(['prefix' => 'post', 'name' => 'post.'], function () {
    /**
     * Get all posts
     */
    Route::get('', [App\Http\Controllers\PostController::class, 'index'])
    ->name('index');

    /**
     * Create a new post
     */
    Route::post('', [App\Http\Controllers\PostController::class, 'create'])
    ->name('create');

    /**
     * Get a post by ID
     */
    Route::get('/id/{id}', [App\Http\Controllers\PostController::class, 'getPostById'])
    ->name('getPostById');

    /**
     * Get all soft-deleted posts
     */
    Route::get('trashed', [App\Http\Controllers\PostController::class, 'trashed'])
      ->name('trashed');

    /**
     * Get a post by name
     */
    Route::get('name/{name}', [App\Http\Controllers\PostController::class, 'getPostByName'])
    ->name('getPostByName');

    /**
     * Update a post
     */
    Route::patch('{id}', [App\Http\Controllers\PostController::class, 'update'])
    ->name('update');

    /**
     * Delete a post
     */
    Route::delete('{id}', [App\Http\Controllers\PostController::class, 'delete'])
    ->name('delete');
});

/**
 * Category
 */
Route::group(['prefix' => 'category', 'name' => 'category.'], function () {
    /**
     * Get all categories
     */
    Route::get('', [App\Http\Controllers\CategoryController::class, 'index'])
    ->name('index');

    /**
     * Get a category by ID
     */
    Route::get('id/{id}', [App\Http\Controllers\CategoryController::class, 'getById'])
    ->name('getById');

    /**
     * Get all trashed categories
     */
    Route::get('trashed', [App\Http\Controllers\CategoryController::class, 'indexTrashed'])
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

/**
 * Tag
 */
Route::group(['prefix' => 'tag', 'name' => 'tag.'], function () {
    /**
     * Get all tags
     */
    Route::get('', [App\Http\Controllers\TagController::class, 'index'])
      ->name('index');

    /**
     * Get a tag by ID
     */
    Route::get('id/{id}', [App\Http\Controllers\TagController::class, 'getById'])
      ->name('getById');

    /**
     * Get all trashed tags
     */
    Route::get('trashed', [App\Http\Controllers\TagController::class, 'trashed'])
      ->name('trashed');

    /**
     * Create a new tag
     */
    Route::post('', [App\Http\Controllers\TagController::class, 'create'])
      ->name('create');

    /**
     * Update a tag
     */
    Route::patch('id/{id}', [App\Http\Controllers\TagController::class, 'update'])
      ->name('update');

    /**
     * Delete a tag
     */
    Route::delete('/id/{id}', [App\Http\Controllers\TagController::class, 'delete'])
      ->name('delete');

    /**
     * Restore a deleted tag
     */
    Route::patch('restore/{id}', [App\Http\Controllers\TagController::class, 'restore'])
      ->name('restore');
});

/**
 * Comment
 */
Route::group(['prefix' => 'comment', 'name' => 'comment.'], function () {
    /**
     * Get all comments
     */
    Route::get('', [App\Http\Controllers\CommentController::class, 'index'])
        ->name('index');

    /**
     * Get a comment by ID
     */
    Route::get('/id/{id}', [App\Http\Controllers\CommentController::class, 'getById'])
        ->name('getById');

    /**
     * Create a new comment
     */
    Route::post('', [App\Http\Controllers\CommentController::class, 'create'])
        ->name('create');

    /**
     * Update a comment
     */
    Route::patch('id/{id}', [App\Http\Controllers\CommentController::class, 'update'])
        ->name('update');

    /**
     * Delete a comment
     */
    Route::delete('id/{id}', [App\Http\Controllers\CommentController::class, 'delete'])
        ->name('delete');

    /**
     * Restore a deleted comment
     */
    Route::patch('restore/{id}', [App\Http\Controllers\CommentController::class, 'restore'])
        ->name('restore');

    /**
     * Force delete a comment
     */
    Route::delete('force/{id}', [App\Http\Controllers\CommentController::class, 'forceDelete'])
        ->name('forceDelete');
});

/**
 * Emotion
 */
Route::group(['prefix' => 'emotion', 'name' => 'emotion.'], function () {
    /**
     * Get all emotions
     */
    Route::get('', [App\Http\Controllers\EmotionController::class, 'index'])
        ->name('index');

    /**
     * Create a new emotion
     */
    Route::post('', [App\Http\Controllers\EmotionController::class, 'store'])
        ->name('create');

    /**
     * Get a emotion by ID
     */
    Route::get('id/{id}', [App\Http\Controllers\EmotionController::class, 'getById'])
        ->name('getById');

    /**
     * Update the specified resource in storage.
     */
    Route::patch('id/{id}', [App\Http\Controllers\EmotionController::class, 'update'])
        ->name('update');

    /**
     * Delete the specified resource from storage.
     */
    Route::delete('id/{id}', [App\Http\Controllers\EmotionController::class, 'delete'])
        ->name('delete');

    /**
     * Restore a soft-deleted emotion.
     */
    Route::patch('restore/{id}', [App\Http\Controllers\EmotionController::class, 'restore'])
        ->name('restore');

    /**
     * Force delete an emotion.
     */
    Route::delete('force/{id}', [App\Http\Controllers\EmotionController::class, 'forceDelete'])
        ->name('forceDelete');

    /**
     * Toggle the specified resource in emotion
     */
    Route::patch('toggle/{id}', [App\Http\Controllers\EmotionController::class, 'toggleEmotion'])
        ->name('toggleEmotion');
});
