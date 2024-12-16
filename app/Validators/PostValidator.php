<?php

namespace App\Validators;

use App\Helper\JsonResponseHelper;
use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PostValidator extends Validator
{
    private $model;

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
            'slug' => 'required|string|between:2,255|unique:posts,slug',
            'content' => 'required|string|max:16777215',
            'publish_status' => 'required|integer|in:0,1,2',
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::notAcceptable('Create post failed', $validated->errors());
        }

        return $validated->validated();
    }

    /**
     * Validate get post by ID request.
     *
     * @param int $id The ID of the post to retrieve.
     * @return array|JsonResponse
     */
    public function getById(int $id, User|Authenticatable $user = Auth::user()): array|JsonResponse
    {
        $validated = Validator::make(compact('id'), [
            'id' => 'required|numeric|exists:posts,id',
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::notAcceptable('Get post failed', $validated->errors());
        }

        if (!$user->isAdmin() && $user->id !== $this->model::find($id)->author) {
            return JsonResponseHelper::unauthorized('You are not authorized to perform this action');
        }

        return $validated->validated();
    }

    public function update(Request $request, int $id, User|Authenticatable $user): array|JsonResponse
    {
        $validId = Validator::make(compact('id'), [
            'id' => 'required|numeric|exists:posts,id',
        ]);

        if ($validId->fails()) {
            return JsonResponseHelper::notAcceptable('Update post failed', $validId->errors());
        }

        if (!$user->isAdmin() && $user->id !== $this->model::find($id)->author) {
            return JsonResponseHelper::unauthorized('You are not authorized to perform this action');
        }

        $validated = Validator::make($request->all(), [
            'title' => [
                'string',
                'between:2,255',
                Rule::unique('posts', 'title')->ignore($id),
            ],
            'slug' => [
                'string',
                'between:2,255',
                Rule::unique('posts', 'slug')->ignore($id),
            ],
            'content' => [
                'string',
                'max:16777215',
            ],
            'publish_status' => 'integer|numeric|in:0,1,2',
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::notAcceptable('Update post failed', $validated->errors());
        }

        return $validated->validated();
    }

    /**
     * Validate delete post request.
     *
     * @param int $id The ID of the post to delete.
     * @return array|JsonResponse
     */
    public function delete(int $id, User|Authenticatable $user = Auth::user()): array|JsonResponse
    {
        $validated = Validator::make(compact('id'), [
            'id' => 'required|numeric|exists:posts,id',
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::notAcceptable('Delete post failed', $validated->errors());
        }

        if (!$user->isAdmin() && $this->model::find($id)->author !== $user->id) {
            return JsonResponseHelper::unauthorized('You are not authorized to perform this action');
        }

        return $validated->validated();
    }
}
