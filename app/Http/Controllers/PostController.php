<?php

namespace App\Http\Controllers;

use App\Helper\JsonResponseHelper;
use App\Repositories\PostRepository;
use App\Validators\PostValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct(PostRepository $repo, PostValidator $validator)
    {
        $this->repo = $repo;
        $this->validator = $validator;
    }

    /**
     * Create a new post.
     *
     * Validates the request using the PostValidator. If validation fails, returns a JsonResponse with the validation errors. Otherwise, sets the author of the post to the authenticated user's ID and attempts to create the post using the PostRepository. If the creation fails, returns an error response.
     * Otherwise, returns a success response with the created post.
     *
     * @param \Illuminate\Http\Request $request The request object containing post data.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the result of the operation.
     */
    public function create(Request $request): JsonResponse
    {
        $validated = $this->validator::create($request);

        if ($validated instanceof JsonResponse) {
            return $validated;
        }

        /** @var \App\Models\User $user */
        $validated['author'] = Auth::user()->id;

        if (!$post = $this->repo->create($validated)) {
            return JsonResponseHelper::error(null, 'Create post failed');
        }

        return JsonResponseHelper::success($post, 'Create post successfully');
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
        $validated = $this->validator::getById($id);

        if ($validated instanceof JsonResponse) {
            return $validated;
        }

        if (!$post = $this->repo->getById($validated)) {
            return JsonResponseHelper::notFound('Post not found');
        }

        return JsonResponseHelper::success($post, 'Get post successfully');
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
        $validated = $this->validator::update($request, $id);

        if ($validated instanceof JsonResponse) {
            return $validated;
        }

        if (!$post = $this->repo->update($validated, $id)) {
            return JsonResponseHelper::error(null, 'Update post failed');
        }

        return JsonResponseHelper::success($post, 'Update post successfully');
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
        $validated = $this->validator::delete($id);

        if ($validated instanceof JsonResponse) {
            return $validated;
        }

        if (!$post = $this->repo->delete($id)) {
            return JsonResponseHelper::notFound('Post not found');
        }

        return JsonResponseHelper::success($post, 'Delete post successfully');
    }
}
