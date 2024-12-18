<?php

namespace App\Http\Controllers;

use App\Repositories\TagRepository;
use App\Validators\TagValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    private $repo;

    private $validator;

    private $user;

    public function __construct(TagRepository $repo, TagValidator $validator)
    {
        $this->repo = $repo;
        $this->validator = $validator;
        $this->user = Auth::user();
    }

    /**
     * Get all tags
     *
     * Get all tags from the database.
     * The result is an array of tags.
     *
     * @return JsonResponse The response containing all tags or an error response
     */
    public function index(): JsonResponse
    {
        $result = $this->repo->index();

        return $this->repoResponse($result, 'Get tags successfully');
    }

    /**
     * Get a tag by its ID
     *
     * Validates the provided ID using the TagValidator. If validation fails, returns a JsonResponse with the validation errors.
     * Otherwise, attempts to retrieve the tag using the TagRepository. If the tag is not found, returns a not found response. Otherwise, returns a success response with the retrieved tag.
     *
     * @param int $id The ID of the tag to retrieve
     * @return JsonResponse The response containing the retrieved tag or an error response
     */
    public function getById(int $id): JsonResponse
    {
        $validated = $this->validator->id($id);

        if ($this->isJsonResponse($validated)) {
            return $validated;
        }

        $result = $this->repo->getById($validated['id']);

        return $this->repoResponse($result, 'Get tag successfully');
    }

    /**
     * Get all soft-deleted tags
     *
     * Retrieve all soft-deleted tags from the database.
     * The result is an array of soft-deleted tags.
     *
     * @return JsonResponse The response containing all soft-deleted tags or an error response
     */
    public function trashed(): JsonResponse
    {
        $result = $this->repo->trashed();

        return $this->repoResponse($result, 'Get trashed tags successfully');
    }

    /**
     * Create a new tag.
     *
     * Validates the request using the TagValidator. If validation fails, returns a JsonResponse with the validation errors.
     * Otherwise, attempts to create the tag using the TagRepository. If the creation fails, returns an error response.
     * Otherwise, returns a success response with the created tag.
     *
     * @param \Illuminate\Http\Request $request The request object containing tag data.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the result of the operation.
     */
    public function create(Request $request): JsonResponse
    {
        $validated = $this->validator->create($request);

        if ($this->isJsonResponse($validated)) {
            return $validated;
        }

        $result = $this->repo->create($validated);

        return $this->repoResponse($result, 'Create tag successfully');
    }

    /**
     * Update a tag.
     *
     * Validates the request data using the TagValidator. If validation fails, it returns a JsonResponse with the validation errors.
     * Otherwise, it attempts to update the tag using the TagRepository. If the update is successful, it returns a success response with the updated tag.
     *
     * @param \Illuminate\Http\Request $request The request containing tag data to update.
     * @param int $id The ID of the tag to update.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the result of the operation.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $this->validator->update($request, $id, $this->user);

        if ($this->isJsonResponse($validated)) {
            return $validated;
        }

        $result = $this->repo->update($validated['id'], $validated);

        return $this->repoResponse($result, 'Update tag successfully');
    }

    /**
     * Delete a tag.
     *
     * Validates the request using the TagValidator. If validation fails, returns a JsonResponse with the validation errors.
     * Otherwise, attempts to delete the tag using the TagRepository. If the deletion fails, returns an error response.
     * Otherwise, returns a success response with the deleted tag.
     *
     * @param int $id The ID of the tag to delete.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the result of the operation.
     */
    public function delete(int $id): JsonResponse
    {
        $validated = $this->validator->delete($id, $this->user);

        if ($this->isJsonResponse($validated)) {
            return $validated;
        }

        $result = $this->repo->delete($validated['id']);

        return $this->repoResponse($result, 'Delete tag successfully');
    }

    /**
     * Restore a deleted tag.
     *
     * Validates the request using the TagValidator. If validation fails, returns a JsonResponse with the validation errors.
     * Otherwise, attempts to restore the tag using the TagRepository. If the restore fails, returns an error response.
     * Otherwise, returns a success response with the restored tag.
     *
     * @param int $id The ID of the tag to restore.
     * @return JsonResponse A JSON response containing the result of the operation.
     */
    public function restore(int $id): JsonResponse
    {
        $validated = $this->validator->restore($id, $this->user);

        if ($this->isJsonResponse($validated)) {
            return $validated;
        }

        $result = $this->repo->restore($validated['id']);

        return $this->repoResponse($result, 'Restore tag successfully');
    }
}
