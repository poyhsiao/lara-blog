<?php

namespace App\Repositories;

use App\Helper\JsonResponseHelper;
use App\Models\Post;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PostRepository extends Repository
{
    private $model;

    public function __construct(Post $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    /**
     * Create a new post
     *
     * Attempts to create a new post in the database using the given data.
     * If creation is successful, the created post is returned. If an
     * error occurs, an error response is returned.
     *
     * @param array $data The data to create the post with.
     * @return Post|JsonResponse The created post or an error response.
     */
    public function create(array $data): Post|JsonResponse
    {
        try {
            DB::transaction(function () use ($data, &$result) {
                return $this->model->create($data);
            });
        } catch (\Exception $e) {
            Log::error('Create post failed', ['message' => $e->getMessage()]);
            return JsonResponseHelper::error(null, 'Create post failed');
        }
    }

    /**
     * Retrieve a post by its ID.
     *
     * This method attempts to retrieve a post from the database using the provided ID.
     * If the post is found, it is returned along with its author details.
     * If an error occurs during the operation, a JSON error response is returned.
     *
     * @param array $validated An array containing the validated ID of the post to retrieve.
     * @return Collection|JsonResponse The post with its author details or a JSON error response.
     */
    public function getById(array $validated): Collection|JsonResponse
    {
        $id = $validated['id'];
        try {
            return $this->model::with('author')
            ->find($id);
        } catch (\Exception $e) {
            Log::error('Failed to get post by ID', [
                'id' => $id,
                'message' => $e->getMessage()
            ]);
            return JsonResponseHelper::error(null, 'Failed to get post by ID');
        }
    }

    /**
     * Update a post
     *
     * Attempts to update a post with the given ID using the given data.
     * If the update is successful, the updated post is returned. If an
     * error occurs, an error response is returned.
     *
     * @param array $data The data to update the post with.
     * @param int $id The ID of the post to update.
     * @return Post|JsonResponse The updated post or an error response.
     */
    public function update(array $data, int $id): Post|JsonResponse
    {
        try {
            $result = null;

            DB::transaction(function () use ($data, $id, &$result) {
                $result = tap($this->model::with('author')->find($id))
                ->update($data);
            });

            return $result;
        } catch (\Exception $e) {
            Log::error('Update post failed', [
                'id' => $id,
                'message' => $e->getMessage()
            ]);
            return JsonResponseHelper::error(null, 'Update post failed');
        }
    }

    /**
     * Delete a post by its validated ID.
     *
     * This method attempts to delete a post from the database using the provided validated ID.
     * If the post is successfully deleted, it returns the deleted Post object.
     * If an error occurs during the deletion process, it logs the error and returns a JsonResponse with an error message.
     *
     * @param array $validated The validated data containing the post ID.
     * @return Post|JsonResponse The deleted Post object or a JsonResponse in case of an error.
     */
    public function delete(array $validated): Post|JsonResponse
    {
        try {
            $id = $validated['id'];
            $result = null;

            DB::transaction(callback: function () use ($id, &$result) {
                $result = tap($this->model::with('author')->find($id))->delete();
            });

            return $result;
        } catch (\Exception $e) {
            Log::error('Delete post failed', [
                'id' => $id,
                'message' => $e->getMessage()
            ]);
            return JsonResponseHelper::error(null, 'Delete post failed');
        }
    }
}
