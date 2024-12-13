<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Repository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PostRepository extends Repository
{
    public function __construct(Post $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    /**
     * Create a new post.
     *
     * @param array $data
     * @return Post|null
     */
    public function create($data): ?Post
    {
        $result = null;

        try {
            DB::transaction(function () use ($data, &$result) {
                $result = $this->model->create($data);
            });
        } catch (\Exception $e) {
            Log::error('Create post failed', ['message' => $e->getMessage()]);
            return null;
        }

        return $result;
    }

    /**
     * Retrieve a post by its ID, including its author.
     *
     * Attempts to find a post with the given ID along with its associated author.
     * If the post is found, it is returned. If an exception occurs, null is returned.
     *
     * @param array $data An array containing the 'id' key, which specifies the post ID to retrieve.
     * @return Post|null The post with the specified ID and its author, or null if not found or on error.
     */
    public function getById(array $data): ?Post
    {
        try {
            $result = $this->model::with('author')
            ->find($data['id']);
        } catch (\Exception $e) {
            Log::error('Failed to get post by ID', [
                'id' => $data['id'],
                'message' => $e->getMessage()
            ]);
            return null;
        }

        return $result ?? null;
    }

    /**
     * Update a post.
     *
     * Updates a post with the given ID, specified in the $data array. If the post is found and the update is successful, the updated post is returned. If an exception occurs, null is returned.
     *
     * @param array $data An associative array containing the post data to update. Must contain the 'id' key.
     * @param int $id The ID of the post to update.
     * @return Post|null The updated post, or null if the post is not found or if an error occurs.
     */
    public function update(array $data, int $id): ?Post
    {
        $result = null;

        try {
            DB::transaction(function () use ($data, $id, &$result) {
                $result = tap($this->model::with('author')->find($id))
                ->update($data);
            });
        } catch (\Exception $e) {
            Log::error('Update post failed', [
                'id' => $id,
                'message' => $e->getMessage()
            ]);
            return null;
        }

        return $result;
    }

    /**
     * Delete a post.
     *
     * Deletes a post with the given ID. If the post is found and the deletion is successful, the deleted post is returned. If an exception occurs, null is returned.
     *
     * @param int $id The ID of the post to delete.
     * @return Post|null The deleted post, or null if the post is not found or if an error occurs.
     */
    public function delete(int $id): ?Post
    {
        $result = null;
        try {
            DB::transaction(function () use ($id, &$result) {
                $result = tap($this->model::with('author')->find($id))->delete();
            });
        } catch (\Exception $e) {
            Log::error('Delete post failed', [
                'id' => $id,
                'message' => $e->getMessage()
            ]);
            return null;
        }

        return $result;
    }
}
