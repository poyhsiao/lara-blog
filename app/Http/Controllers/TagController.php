<?php

namespace App\Http\Controllers;

use App\Helper\JsonResponseHelper;
use App\Repositories\TagRepository;
use App\Validators\TagValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TagController extends Controller
{
    private $repo;

    private $validator;

    public function __construct(TagRepository $repo, TagValidator $validator)
    {
        $this->repo = $repo;
        $this->validator = $validator;
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

    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $this->validator->update($request, $id);

        if ($this->isJsonResponse($validated)) {
            return $validated;
        }

        $result = $this->repo->update($validated['id'], $validated);

        return $this->repoResponse($result, 'Update tag successfully');
    }
}
