<?php

namespace App\Validators;

use App\Helper\JsonResponseHelper;
use App\Models\Post;
use App\Models\User;
use App\Rules\ExistInDb;
use App\Rules\IdAvailable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PostValidator extends BaseValidator
{
    protected $model;

    public function __construct(Post $model)
    {
        $this->model = $model;
    }

    /**
     * Validate create post request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|JsonResponse
     */
    public function create(Request $request): array|JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'title' => 'required|string|between:2,255|unique:posts,title',
            'content' => 'required|string|max:16777215',
            'publish_status' => 'required|integer|in:0,1,2',
            'category_ids' => [
                'required',
                'array',
                new ExistInDb('categories', 'id', 'some categories not found'),
            ],
            'tag_ids' => [
                'array',
                new ExistInDb('tags', 'id', 'some tags not found'),
            ],
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::notAcceptable('Create post failed', $validated->errors());
        }

        return $validated->validated();
    }

    /**
     * Validate get post by ID request.
     *
     * @param int $postId The ID of the post to retrieve.
     * @return array|JsonResponse
     */
    public function getById(int $postId, User|Authenticatable $user): array|JsonResponse
    {
        $requestData = ['id' => $postId];
        $validationRules = ['id' => 'required|numeric|exists:posts,id'];

        $validator = Validator::make($requestData, $validationRules);

        if ($validator->fails()) {
            return JsonResponseHelper::notAcceptable('Get post failed', $validator->errors());
        }

        if (!$this->isUserAuthorized($user, $this->model::find($postId))) {
            return JsonResponseHelper::unauthorized('You are not authorized to perform this action');
        }

        return $validator->validated();
    }

    /**
     * Validate update post request.
     *
     * This method first validates the provided post ID to ensure it exists.
     * If the ID validation fails, it returns a JsonResponse with the validation errors.
     * Then, it checks if the user is authorized to update the post.
     * If the user is not an admin and not the author of the post, it returns an unauthorized response.
     * It then validates the post update data from the request to ensure:
     * - the 'title' is a string, between 2 and 255 characters, and unique among posts.
     * - the 'slug' is a string, between 2 and 255 characters, and unique among posts.
     * - the 'content' is a string and maximum of 16777215 characters.
     * - the 'publish_status' is an integer and in [0, 1, 2].
     * If any validation fails, it returns a JsonResponse with the errors.
     * Otherwise, it returns the validated data.
     *
     * @param \Illuminate\Http\Request $request The request object containing post data to update.
     * @param int $postId The ID of the post to update.
     * @param \App\Models\User|\Illuminate\Contracts\Auth\Authenticatable $user The user attempting the update.
     * @return array|JsonResponse The validated data or a JsonResponse with validation errors or unauthorized response.
     */
    public function update(Request $request, int $postId, User|Authenticatable $user): array|JsonResponse
    {
        $idValidation = Validator::make(['id' => $postId], [
            'id' => [
                'required',
                'numeric',
                new IdAvailable('posts', 'id', 'Post not found'),
            ],
        ]);

        if ($idValidation->fails()) {
            return JsonResponseHelper::notAcceptable('Update post failed', $idValidation->errors());
        }

        if (!$this->isUserAuthorized($user, $this->model::find($postId))) {
            return JsonResponseHelper::unauthorized('You are not authorized to perform this action');
        }

        $postValidation = Validator::make($request->all(), [
            'title' => [
                'string',
                'between:2,255',
                Rule::unique('posts', 'title')->ignore($postId),
            ],
            'content' => [
                'string',
                'max:16777215',
            ],
            'publish_status' => 'integer|in:0,1,2',
            'category_ids' => [
                'array',
                new ExistInDb('categories', 'id', 'some categories not found'),
            ],
            'tag_ids' => [
                'array',
                new ExistInDb('tags', 'id', 'some tags not found'),
            ],
        ]);

        if ($postValidation->fails()) {
            return JsonResponseHelper::notAcceptable('Update post failed', $postValidation->errors());
        }

        return $postValidation->validated();
    }

    /**
     * Validate delete post request.
     *
     * @param int $postId The ID of the post to delete.
     * @return array|JsonResponse
     */
    public function delete(int $postId, User|Authenticatable $user): array|JsonResponse
    {
        $validation = Validator::make(['postId' => $postId], [
            'postId' => [
                'required',
                'numeric',
                new IdAvailable('posts', 'id', 'Post not found'),
            ],
        ]);

        if ($validation->fails()) {
            return JsonResponseHelper::notAcceptable('Delete post failed', $validation->errors());
        }

        if (!$this->isUserAuthorized($user, $this->model::find($postId))) {
            return JsonResponseHelper::unauthorized('You are not authorized to perform this action');
        }

        return $validation->validated();
    }

    /**
     * Validate restore post request.
     *
     * This method validates the provided post ID to ensure it exists.
     * If the ID validation fails, it returns a JsonResponse with the validation errors.
     * Otherwise, it returns the validated data.
     *
     * @param int $postId The ID of the post to restore.
     * @return array|JsonResponse The validated data or a JsonResponse with validation errors.
     */
    public function restore(int $postId): array|JsonResponse
    {
        $validation = Validator::make(['id' => $postId], [
            'id' => 'required|numeric|exists:posts,id',
        ]);

        if ($validation->fails()) {
            return JsonResponseHelper::notAcceptable('Restore post failed', $validation->errors());
        }

        return $validation->validated();
    }

    /**
     * Validate force delete post request.
     *
     * This method validates the provided post ID to ensure it exists.
     * If the ID validation fails, it returns a JsonResponse with the validation errors.
     * Otherwise, it returns the validated data.
     *
     * @param int $postId The ID of the post to force delete.
     * @return array|JsonResponse The validated data or a JsonResponse with validation errors.
     */
    public function forceDelete(int $postId): array|JsonResponse
    {
        $validation = Validator::make(['id' => $postId], [
            'id' => 'required|numeric|exists:posts,id',
        ]);

        if ($validation->fails()) {
            return JsonResponseHelper::notAcceptable('Force delete post failed', $validation->errors());
        }

        return $validation->validated();
    }

    /**
     * Verify if the user is authorized to perform an action on a post.
     *
     * @param  User|Authenticatable  $user  The user attempting to perform the action.
     * @param  Post  $post  The post on which the action is being performed.
     * @return bool True if authorized, false otherwise.
     */
    private function isUserAuthorized(User|Authenticatable $user, Post $post): bool
    {
        return $user->isAdmin() || $post->user_id === $user->id;
    }
}
