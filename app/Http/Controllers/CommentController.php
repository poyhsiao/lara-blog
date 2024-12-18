<?php

namespace App\Http\Controllers;

use App\Repositories\CommentRepository;
use App\Validators\CommentValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    protected $repo;

    protected $validator;

    protected $user;

    public function __construct(CommentRepository $repo, CommentValidator $validator)
    {
        $this->repo = $repo;
        $this->validator = $validator;
        $this->user = Auth::user();
    }

    /**
     * Get all comments
     *
     * Get all comments from the database.
     * The result is a JSON response containing all comments or an error message.
     *
     * @return JsonResponse The response containing all comments or an error message
     */
    public function index(): JsonResponse
    {
        dump(3333);
        $result = $this->repo->index();

        return $this->repoResponse($result, 'Get comments successfully');
    }

    /**
     * Retrieve a comment by its ID.
     *
     * Validates the provided ID using the CommentValidator. If validation fails, returns a JsonResponse with the validation errors.
     * Otherwise, attempts to retrieve the comment using the CommentRepository. If the comment is not found, returns an error response.
     * Otherwise, returns a success response with the retrieved comment.
     *
     * @param int $id The ID of the comment to retrieve.
     * @return JsonResponse A JSON response containing the retrieved comment or an error response.
     */
    public function getById(int $id): JsonResponse
    {
        $validated = $this->validator->getById($id, $this->user);

        if ($this->isJsonResponse($validated)) {
            return $validated;
        }

        $result = $this->repo->getById($validated['id']);

        return $this->repoResponse($result, 'Get comment successfully');
    }

    /**
     * Create a new comment.
     *
     * Validates the provided data using the CommentValidator. If validation fails, returns a JsonResponse with the validation errors.
     * Otherwise, attempts to create the comment using the CommentRepository. If creation fails, returns an error response.
     * Otherwise, returns a success response with the created comment.
     *
     * @param \Illuminate\Http\Request $request The request object containing comment data.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the result of the operation.
     */
    public function create(Request $request): JsonResponse
    {
        $validated = $this->validator->create($request);

        if ($this->isJsonResponse($validated)) {
            return $validated;
        }

        /**
         * Assign the user ID to the validated data
         */
        $validated['user_id'] = $this->user->id;

        $result = $this->repo->create($validated);

        return $this->repoResponse($result, 'Create comment successfully');
    }

    /**
     * Update a comment.
     *
     * Validates the provided data using the CommentValidator. If validation fails, returns a JsonResponse with the validation errors.
     * Otherwise, attempts to update the comment using the CommentRepository. If update fails, returns an error response.
     * Otherwise, returns a success response with the updated comment.
     *
     * @param \Illuminate\Http\Request $request The request object containing comment data to update.
     * @param int $id The ID of the comment to update.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the result of the operation.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $this->validator->update($request, $id, $this->user);

        if ($this->isJsonResponse($validated)) {
            return $validated;
        }

        $result = $this->repo->update($validated, $id);

        return $this->repoResponse($result,'Update comment successfully');
    }

    /**
     * Delete a comment.
     *
     * Validates the provided ID using the CommentValidator. If validation fails, returns a JsonResponse with the validation errors.
     * Otherwise, attempts to delete the comment using the CommentRepository. If the deletion fails, returns an error response.
     * Otherwise, returns a success response with the deleted comment.
     *
     * @param int $id The ID of the comment to delete.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the result of the operation.
     */
    public function delete(int $id): JsonResponse
    {
        $validated = $this->validator->delete($id, $this->user);

        if ($this->isJsonResponse($validated)) {
            return $validated;
        }

        $result = $this->repo->delete($validated['id']);

        return $this->repoResponse($result,'Delete comment successfully');
    }

    /**
     * Restore a deleted comment.
     *
     * Validates the provided ID using the CommentValidator. If validation fails, returns a JsonResponse with the validation errors.
     * Otherwise, attempts to restore the comment using the CommentRepository. If restoration fails, returns an error response.
     * Otherwise, returns a success response with the restored comment.
     *
     * @param int $id The ID of the comment to restore.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the result of the operation.
     */
    public function restore(int $id): JsonResponse
    {
        $validated = $this->validator->restore($id, $this->user);

        if ($this->isJsonResponse($validated)) {
            return $validated;
        }

        $result = $this->repo->restore($validated['id']);

        return $this->repoResponse($result,'Restore comment successfully');
    }

    /**
     * Permanently delete a comment.
     *
     * Validates the provided ID using the CommentValidator. If validation fails, returns a JsonResponse with the validation errors.
     * Otherwise, attempts to forcefully delete the comment using the CommentRepository. If the deletion fails, returns an error response.
     * Otherwise, returns a success response indicating the comment was successfully deleted.
     *
     * @param int $id The ID of the comment to force delete.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the result of the operation.
     */

    public function forceDelete(int $id): JsonResponse
    {
        $validated = $this->validator->forceDelete($id, $this->user);

        if ($this->isJsonResponse($validated)) {
            return $validated;
        }

        $result = $this->repo->forceDelete($validated['id'], $this->user);

        return $this->repoResponse($result,'Force delete comment successfully');
    }
}
