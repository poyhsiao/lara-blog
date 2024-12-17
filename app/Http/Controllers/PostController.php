<?php

namespace App\Http\Controllers;

use App\Repositories\PostRepository;
use App\Validators\PostValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    private $repo;

    private $validator;

    private $user;

    public function __construct(PostRepository $repo, PostValidator $validator)
    {
        $this->repo = $repo;
        $this->validator = $validator;
        $this->user = Auth::user();
    }

    /**
     * Create a new post.
     *
     * Validates the request using the PostValidator. If validation fails, returns a JsonResponse with the validation errors.
     * Otherwise, sets the author of the post to the authenticated user's ID and attempts to create the post using the PostRepository.
     * If the creation fails, returns an error response. Otherwise, returns a success response with the created post.
     *
     * @param \Illuminate\Http\Request $request The request object containing post data.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the result of the operation.
     */
    public function create(Request $request): JsonResponse
    {
        $postData = $this->validator->create($request);

        if ($this->isJsonResponse($postData)) {
            return $postData;
        }

        $postData['author'] = Auth::id();

        $result = $this->repo->create($postData);

        return $this->repoResponse($result, 'Create post successfully');
    }

    /**
     * Retrieve a post by its ID.
     *
     * Validates the provided ID using the PostValidator. If validation fails, returns a JsonResponse with the validation errors. Otherwise, attempts to retrieve the post using the PostRepository. If the post is not found, returns a not found response. Otherwise, returns a success response with the retrieved post.
     *
     * @param int $id The ID of the post to retrieve.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the result of the operation.
     */
    public function getPostById(int $id): JsonResponse
    {
        $validated = $this->validator->getById($id, $this->user);

        if ($this->isJsonResponse( $validated)) {
            return $validated;
        }

        $result = $this->repo->getById($validated);

        return $this->repoResponse($result, 'Get post successfully');
    }

    /**
     * Update a post.
     *
     * Validates the provided data using the PostValidator. If validation fails, returns a JsonResponse with the validation errors. Otherwise, attempts to update the post using the PostRepository. If the post is not found, returns a not found response. Otherwise, returns a success response with the updated post.
     *
     * @param \Illuminate\Http\Request $request The request object containing the data to update.
     * @param int $id The ID of the post to update.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the result of the operation.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $this->validator->update($request, $id, $this->user);

        if ($this->isJsonResponse($validated)) {
            return $validated;
        }

        $result = $this->repo->update($validated, $id);

        return $this->repoResponse($result, 'Update post successfully');
    }

    /**
     * Delete a post.
     *
     * Validates the provided ID using the PostValidator. If validation fails, returns a JsonResponse with the validation errors. Otherwise, attempts to delete the post using the PostRepository. If the post is not found, returns a not found response. Otherwise, returns a success response with the deleted post.
     *
     * @param int $id The ID of the post to delete.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the result of the operation.
     */
    public function delete(int $id): JsonResponse
    {
        $validated = $this->validator->delete($id, $this->user);

        if ($this->isJsonResponse($validated)) {
            return $validated;
        }

        $result = $this->repo->delete($validated);

        return $this->repoResponse($result, 'Delete post successfully');
    }
}
