<?php

namespace App\Validators;

use App\Helper\JsonResponseHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PostValidator
{
    /**
     * Validate create post request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|JsonResponse
     */
    public static function create(Request $request): array|JsonResponse
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
    public static function getById(int $id): array|JsonResponse
    {
        $validated = Validator::make(compact('id'), [
            'id' => 'required|numeric|exists:posts,id',
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::notAcceptable('Get post failed', $validated->errors());
        }

        return $validated->validated();
    }

    /**
     * Validate update post request.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id The ID of the post to update.
     * @return array|JsonResponse
     */
    public static function update(Request $request, int $id): array|JsonResponse
    {
        $validId = Validator::make(compact('id'), [
            'id' => 'required|numeric|exists:posts,id',
        ]);

        if ($validId->fails()) {
            return JsonResponseHelper::notAcceptable('Update post failed', $validId->errors());
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
    public static function delete(int $id): array|JsonResponse
    {
      $validated = Validator::make(compact('id'), [
        'id'=> 'required|numeric|exists:posts,id',
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::notAcceptable('Delete post failed', $validated->errors());
        }

        return $validated->validated();
    }
}
