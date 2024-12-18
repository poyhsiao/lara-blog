<?php

namespace App\Validators;

use App\Helper\JsonResponseHelper;
use App\Models\Comment;
use App\Models\User;
use App\Rules\IdAvailable;
use App\Rules\IdTrashedRule;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CommentValidator extends BaseValidator
{
    protected $model;

    public function __construct(Comment $model)
    {
        $this->model = $model;
    }

    /**
     * Validate the comment ID.
     *
     * This method checks if the provided ID is a valid numeric value and exists in the comments table.
     * If validation fails, it returns a JsonResponse with the validation errors.
     * Otherwise, it returns the validated ID as an integer.
     * @param int $commentId The ID of the comment to validate.
     * @return array|JsonResponse The validated ID as an integer or a JsonResponse with validation errors.
     */
    public function validateId(int $commentId): array|JsonResponse
    {
        $validated = Validator::make(['id' => $commentId], [
            'id' => 'required|integer|exists:comments,id',
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::notAcceptable('Get comment failed', ['message' => $validated->errors()]);
        }

        return $validated->validated();
    }

    /**
     * Validate get comment by ID request.
     *
     * Validates the provided ID and checks if the user is authorized to get the comment.
     * If validation fails, returns a JsonResponse with the validation errors.
     * Otherwise, returns the validated data.
     *
     * @param int $commentId The ID of the comment to retrieve.
     * @param \App\Models\User|\Illuminate\Contracts\Auth\Authenticatable $user The user attempting to get the comment.
     * @return array|JsonResponse The validated data or a JsonResponse with validation errors or unauthorized response.
     */
    public function getById(int $commentId, User|Authenticatable $user): array|JsonResponse
    {
        $validator = $this->validateId($commentId);

        if ($validator instanceof JsonResponse) {
            return $validator;
        }

        try {
            $theComment = $this->model::find($validator['id']);

            if (!$user->isAdmin() && $theComment->user_id !== $user->id) {
                return JsonResponseHelper::notAcceptable('You are not allowed to get this comment');
            }
        } catch (\Exception $e) {
            Log::error('Get comment failed', ['message' => $e->getMessage()]);
            return JsonResponseHelper::error(null, 'Get comment failed');
        }

        return $validator;
    }

    /**
     * Validate create comment request.
     *
     * This method checks if the provided comment data is valid. The content must be a string with a maximum length of 16777215, the replyable must be an integer with a value of 0 or 1, the post ID must be a valid integer that exists in the posts table and the parent ID must be an integer that exists in the comments table or null.
     * If validation fails, it returns a JsonResponse with the validation errors. Otherwise, it returns the validated data as an array.
     * @param Request $request The request object containing comment data.
     * @return array|JsonResponse The validated data as an array or a JsonResponse with validation errors.
     */
    public function create(Request $request): array|JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'content' => 'required|string|max:16777215',
            'replyable' => 'required|integer|in:0,1',
            'post_id' => [
                'required',
                'integer',
                new IdAvailable('posts', 'id', 'Post not found'),
            ],
            'parent_id' => 'integer|nullable|exists:comments,id',
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::notAcceptable('Create comment failed', ['message' => $validated->errors()]);
        }

        return $validated->validated();
    }

    /**
     * Validate update comment request.
     *
     * This method checks if the provided comment update data is valid. The content must be a string with a maximum length of 16777215, the replyable must be an integer with a value of 0 or 1, the parent ID must be an integer that exists in the comments table or null and not equal to the ID of the comment to update.
     * If validation fails, it returns a JsonResponse with the validation errors. Otherwise, it returns the validated data as an array.
     * @param Request $request The request object containing comment data to update.
     * @param int $id The ID of the comment to update.
     * @return array|JsonResponse The validated data as an array or a JsonResponse with validation errors.
     */
    public function update(Request $request, int $id, User|Authenticatable $user): array|JsonResponse
    {
        $theId = $this->validateId($id);

        if ($theId instanceof JsonResponse) {
            return $theId;
        }

        if (!$user->isAdmin() && $theId['id'] !== $user->id) {
            return JsonResponseHelper::unauthorized('You are not allowed to update this comment');
        }

        $validated = Validator::make($request->all(), [
            'content' => 'string|max:16777215',
            'replyable' => 'integer|in:0,1',
            'parent_id' => [
                'integer',
                'nullable',
                'exists:comments,id',
                Rule::notIn([$id]),
            ],
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::notAcceptable('Update comment failed', ['message' => $validated->errors()]);
        }

        return $validated->validated();
    }

    /**
     * Validate delete comment request.
     *
     * This method checks if the provided comment ID is valid. The ID must be an integer that exists in the comments table.
     * If validation fails, it returns a JsonResponse with the validation errors.
     * Otherwise, it checks if the user is authorized to delete the comment. If the user is not authorized, returns an unauthorized response.
     * Otherwise, it returns the validated ID as an integer.
     * @param int $commentId The ID of the comment to delete.
     * @return array|JsonResponse The validated ID as an integer or a JsonResponse with validation errors or unauthorized response.
     */
    public function delete(int $commentId, User|Authenticatable $user): array|JsonResponse
    {
        $validated = Validator::make(['id' => $commentId], [
            'id' => [
                'integer',
                'exists:comments,id',
                new IdAvailable('comments', 'id', 'Comment not found'),
            ]
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::notAcceptable('Delete comment failed', ['message' => $validated->errors()]);
        }

        if (!$user->isAdmin() && Comment::find($commentId)->user_id !== $user->id) {
            return JsonResponseHelper::unauthorized('You are not allowed to update this comment');
        }

        return $validated->validated();
    }

    public function restore(int $commentId, User|Authenticatable $user): array|JsonResponse
    {
        $validated = Validator::make(['id'=> $commentId], [
            'id' => [
                'required',
                'integer',
                'exists:comments,id',
                new IdTrashedRule('comments', 'id', 'Comment not found'),
            ],
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::notAcceptable('Restore comment failed', ['message' => $validated->errors()]);
        }

        if (!$user->isAdmin()) {
            return JsonResponseHelper::notAcceptable('You do not have permission to restore this comment');
        }

        return $validated->validated();
    }

    /**
     * Validate force delete comment request.
     *
     * This method checks if the provided comment ID is valid and if the user is authorized to force delete the comment.
     * If validation fails, it returns a JsonResponse with the validation errors or unauthorized response.
     * Otherwise, it returns the validated ID as an integer.
     *
     * @param int $commentId The ID of the comment to force delete.
     * @param User|Authenticatable $user The user attempting to force delete the comment.
     * @return array|JsonResponse The validated ID as an integer or a JsonResponse with validation errors or unauthorized response.
     */

    public function forceDelete(int $commentId, User|Authenticatable $user): array|JsonResponse
    {
        $theId = $this->validateId($commentId);

        if ($theId instanceof JsonResponse) {
            return $theId;
        }

        if (!$user->isAdmin()) {
            return JsonResponseHelper::notAcceptable('You do not have permission to delete this comment');
        }

        return $theId;

    }
}
