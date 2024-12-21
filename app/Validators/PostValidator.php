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

        if (!$user->isAdmin() && $user->id !== $this->model::find($postId)->user_id) {
            return JsonResponseHelper::unauthorized('You are not authorized to perform this action');
        }

        return $validator->validated();
    }

    /**
     * Check if the user is authorized to view trashed posts.
     *
     * This method checks if the provided user is an admin. If the user is not an admin,
     * it returns an unauthorized JsonResponse. Otherwise, it returns true indicating
     * the user is authorized to perform the action.
     *
     * @param \App\Models\User|\Illuminate\Contracts\Auth\Authenticatable $user The user attempting to perform the action.
     * @return bool|JsonResponse True if authorized, or a JsonResponse if unauthorized.
     */
    public function trashed(User|Authenticatable $user): bool|JsonResponse
    {
        if (!$user->isAdmin()) {
            return JsonResponseHelper::unauthorized('You are not authorized to perform this action');
        }

        return true;
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

        $post = $this->model::find($postId);

        if (!$user->isAdmin() && $user->id !== $post->author) {
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

        $post = $this->model::find($postId);

        if (!$user->isAdmin() && $post->author !== $user->id) {
            return JsonResponseHelper::unauthorized('You are not authorized to perform this action');
        }

        return $validation->validated();
    }
}
