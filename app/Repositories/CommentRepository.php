<?php

namespace App\Repositories;

use App\Helper\JsonResponseHelper;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommentRepository extends BaseRepository
{
    protected $model;

    public function __construct(Comment $model)
    {
        $this->model = $model;
    }

    /**
     * Get all comments
     *
     * Get all comments from the database.
     * The result is an array of comments or a JsonResponse in case of error
     *
     * @return array|JsonResponse An array of comments or a JsonResponse in case of error
     */
    public function index(): array|JsonResponse
    {
        try {
            return $this->model::all()->toArray();
        } catch (\Exception $e) {
            Log::error('Fail to get comments', ['message' => $e->getMessage()]);
            return JsonResponseHelper::error(null, 'Fail to get comments');
        }
    }

    /**
     * Get a comment by its ID
     *
     * Retrieves a comment by its ID from the database.
     * The result is a JsonResponse containing the comment data or an error response.
     *
     * @param int $commentId The ID of the comment to retrieve.
     * @return JsonResponse A JSON response containing the retrieved comment or an error response.
     */
    public function getById(int $commentId): JsonResponse
    {
        try {
            $comment = $this->model::find($commentId);

            return JsonResponseHelper::success($comment, 'Get comment successfully');
        } catch (\Exception $exception) {
            Log::error('Failed to get comment', [
                'comment_id' => $commentId,
                'message' => $exception->getMessage(),
            ]);

            return JsonResponseHelper::error(null, 'Failed to get comment');
        }
    }

    /**
     * Create a new comment
     *
     * Creates a new comment in the database. If creation is successful, the created comment is returned. If an
     * error occurs, an error response is returned.
     *
     * @param array $data The data to create the comment with.
     * @return Comment|JsonResponse The created comment or an error response.
     */
    public function create(array $data): Comment|JsonResponse
    {
        try {
            return DB::transaction(function () use ($data, &$result) {
                return $this->model::create($data);
            });
        } catch (\Exception $e) {
            Log::error('Failed to create comment', [
                'data' => $data,
                'message' => $e->getMessage(),
            ]);
            return JsonResponseHelper::error(null, 'Failed to create comment');
        }
    }

    /**
     * Update a comment
     *
     * Attempts to update a comment with the given ID using the provided data.
     * If the update is successful, the updated comment is returned. If an error occurs, an error response is returned.
     *
     * @param array $data The data to update the comment with.
     * @param int $commentId The ID of the comment to update.
     * @return Comment|JsonResponse The updated comment or an error response.
     */
    public function update(array $data, int $commentId): Comment|JsonResponse
    {
        try {
            $result = null;

            DB::transaction(function () use ($data, $commentId, &$result) {
                $result = tap($this->model::find($commentId))
                    ->update($data);
            });

            return $result;
        } catch (\Exception $e) {
            Log::error('Failed to update comment', [
                'data' => $data,
                'message' => $e->getMessage(),
            ]);
            return JsonResponseHelper::error(null, 'Failed to update comment');
        }
    }

    /**
     * Delete a comment.
     *
     * Attempts to delete a comment with the given ID from the database.
     * If the comment is successfully deleted, it returns the deleted comment.
     * If the comment is not found or an exception occurs, an error response is returned.
     *
     * @param int $commentId The ID of the comment to delete.
     * @return Comment|JsonResponse The deleted comment, or an error response if the comment is not found or if an error occurs.
     */
    public function delete(int $commentId): Comment|JsonResponse
    {
        try {
            $comment = $this->model::find($commentId);

            DB::transaction(function () use ($comment) {
                $comment->delete();
            });

            return $comment;
        } catch (\Exception $e) {
            Log::error('Failed to delete comment', [
                'comment_id' => $commentId,
                'message' => $e->getMessage(),
            ]);
            return JsonResponseHelper::error(null, 'Failed to delete comment');
        }
    }

    /**
     * Restore a soft-deleted comment.
     *
     * Attempts to restore a comment with the given ID from the database.
     * If the comment is successfully restored, it returns the restored comment.
     * If the comment is not found or an exception occurs, an error response is returned.
     *
     * @param int $commentId The ID of the comment to restore.
     * @return Comment|JsonResponse The restored comment, or an error response if the comment is not found or if an error occurs.
     */
    public function restore(int $commentId): Comment|JsonResponse
    {
        try {
            $result = null;

            DB::transaction(function () use ($commentId, &$result) {
                $result = tap($this->model::onlyTrashed()->find($commentId))->restore();
            });

            return $result;
        } catch (\Exception $e) {
            Log::error('Failed to restore comment', [
                'comment_id' => $commentId,
                'message' => $e->getMessage(),
            ]);
            return JsonResponseHelper::error(null, 'Failed to restore comment');
        }
    }

    /**
     * Permanently delete a comment.
     *
     * Attempts to forcefully delete a comment with the given ID from the database.
     * If the comment is successfully deleted, it returns the deleted comment and logs the action.
     * If the comment is not found or an exception occurs, an error response is returned.
     *
     * @param int $commentId The ID of the comment to permanently delete.
     * @param User|Authenticatable $user The user attempting to delete the comment.
     * @return Comment|JsonResponse The deleted comment, or an error response if the comment is not found or if an error occurs.
     */

    public function forceDelete(int $commentId, User|Authenticatable $user): Comment|JsonResponse
    {
        try {
            $result = null;

            DB::transaction(function () use ($commentId, &$result) {
                $result = tap($this->model::withTrashed()->find($commentId)->makeVisible(['user_id', 'post_id', 'parent_id', 'deleted_at']))->forceDelete();
            });

            Log::info('Force delete comment successfully', [
                'user_id' => $user->id,
                'comment' => $result,
                'datetime' => now(),
            ]);

            return $result;
        } catch (\Exception $e) {
            Log::error('Failed to force delete comment', [
                'user_id' => $user->id,
                'comment_id' => $commentId,
                'message' => $e->getMessage(),
            ]);
            return JsonResponseHelper::error(null, 'Failed to force delete comment');
        }
    }
}
