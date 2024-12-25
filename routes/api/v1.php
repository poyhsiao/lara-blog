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

    Route::get('verify-email', [App\Http\Controllers\JWTAuthController::class,'emailVerifycationRequest'])
      ->name('verify-email');

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
Route::group(['prefix' => 'user', 'name' => 'user.', 'middleware' => ['jwt', 'verified']], function () {
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
Route::group(['prefix' => 'post', 'name' => 'post.', 'middleware' => ['jwt', 'verified']], function () {
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
     * Get all soft-deleted posts (admin required)
     */
    Route::get('trashed', [App\Http\Controllers\PostController::class, 'trashed'])
        ->middleware('jwt-admin')
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

    /**
     * Restore a deleted post (admin required)
     */
    Route::patch('restore/{id}', [App\Http\Controllers\PostController::class, 'restore'])
        ->middleware('jwt-admin')
        ->name('restore');

    /**
     * Force delete a post (admin required)
     */
    Route::delete('force/{id}', [App\Http\Controllers\PostController::class, 'forceDelete'])
        ->middleware('jwt-admin')
        ->name('forceDelete');
});

/**
 * Category
 */
Route::group(['prefix' => 'category', 'name' => 'category.', 'middleware' => ['jwt', 'verified']], function () {
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
     * Get all trashed categories (admin required)
     */
    Route::get('trashed', [App\Http\Controllers\CategoryController::class, 'indexTrashed'])
        ->middleware('jwt-admin')
        ->name('getTrashed');

    /**
     * Create a new category (admin required)
     */
    Route::post('', [App\Http\Controllers\CategoryController::class, 'create'])
        ->middleware('jwt-admin')
        ->name('create');

    /**
     * Update a category (admin required)
     */
    Route::patch('{id}', [App\Http\Controllers\CategoryController::class, 'update'])
        ->middleware('jwt-admin')
        ->name('update');

    /**
     * Delete a category (admin required)
     */
    Route::delete('{id}', [App\Http\Controllers\CategoryController::class, 'delete'])
        ->middleware('jwt-admin')
        ->name('delete');

    /**
     * Restore a deleted category (admin required)
     */
    Route::patch('/restore/{id}', [App\Http\Controllers\CategoryController::class, 'restore'])
        ->middleware('jwt-admin')
        ->name('restore');
});

/**
 * Tag
 */
Route::group(['prefix' => 'tag', 'name' => 'tag.', 'middleware' => ['jwt', 'verified']], function () {
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
     * Update a tag (admin required)
     */
    Route::patch('id/{id}', [App\Http\Controllers\TagController::class, 'update'])
        ->middleware('jwt-admin')
        ->name('update');

    /**
     * Delete a tag (admin required)
     */
    Route::delete('/id/{id}', [App\Http\Controllers\TagController::class, 'delete'])
        ->middleware('jwt-admin')
        ->name('delete');

    /**
     * Restore a deleted tag (admin required)
     */
    Route::patch('restore/{id}', [App\Http\Controllers\TagController::class, 'restore'])
        ->middleware('jwt-admin')
        ->name('restore');
});

/**
 * Comment
 */
Route::group(['prefix' => 'comment', 'name' => 'comment.', 'middleware' => ['jwt', 'verified']], function () {
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
     * Restore a deleted comment (admin required)
     */
    Route::patch('restore/{id}', [App\Http\Controllers\CommentController::class, 'restore'])
        ->middleware('jwt-admin')
        ->name('restore');

    /**
     * Force delete a comment (admin required)
     */
    Route::delete('force/{id}', [App\Http\Controllers\CommentController::class, 'forceDelete'])
        ->middleware('jwt-admin')
        ->name('forceDelete');
});

/**
 * Emotion
 */
Route::group(['prefix' => 'emotion', 'name' => 'emotion.', 'middleware' => ['jwt', 'verified']], function () {
    /**
     * Get all emotions
     */
    Route::get('', [App\Http\Controllers\EmotionController::class, 'index'])
        ->name('index');

    /**
     * Create a new emotion (admin required)
     */
    Route::post('', [App\Http\Controllers\EmotionController::class, 'store'])
        ->middleware('jwt-admin')
        ->name('create');

    /**
     * Get a emotion by ID (admin required)
     */
    Route::get('id/{id}', [App\Http\Controllers\EmotionController::class, 'getById'])
        ->middleware('jwt-admin')
        ->name('getById');

    /**
     * Update the specified resource in storage. (admin required)
     */
    Route::patch('id/{id}', [App\Http\Controllers\EmotionController::class, 'update'])
        ->middleware('jwt-admin')
        ->name('update');

    /**
     * Delete the specified resource from storage. (admin required)
     */
    Route::delete('id/{id}', [App\Http\Controllers\EmotionController::class, 'delete'])
        ->middleware('jwt-admin')
        ->name('delete');

    /**
     * Restore a soft-deleted emotion. (admin required)
     */
    Route::patch('restore/{id}', [App\Http\Controllers\EmotionController::class, 'restore'])
        ->middleware('jwt-admin')
        ->name('restore');

    /**
     * Force delete an emotion. (admin required)
     */
    Route::delete('force/{id}', [App\Http\Controllers\EmotionController::class, 'forceDelete'])
        ->middleware('jwt-admin')
        ->name('forceDelete');

    /**
     * Toggle the specified resource in emotion
     */
    Route::patch('toggle/{id}', [App\Http\Controllers\EmotionController::class, 'toggleEmotion'])
        ->name('toggleEmotion');
});
