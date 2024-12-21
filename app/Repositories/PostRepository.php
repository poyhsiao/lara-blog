<?php

namespace App\Repositories;

use App\Helper\JsonResponseHelper;
use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;

class PostRepository extends BaseRepository
{
    protected $model;

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
            $result = null;

            DB::transaction(function () use ($data, &$result) {
                $result = $this->model->create(Arr::except($data, ['slug', 'tag_ids', 'category_ids']));

                if (array_key_exists('tag_ids', $data) && count($data['tag_ids'])) {
                    $result->tags()->sync($data['tag_ids']);
                }

                if (array_key_exists('category_ids', $data) && count($data['category_ids'])) {
                    $result->categories()->sync($data['category_ids']);
                }
            });

            return $result;
        } catch (\Exception $e) {
            Log::error('Create post failed', [
                'data' => $data,
                'message' => $e->getMessage(),
            ]);
            return JsonResponseHelper::error(null, 'Create post failed');
        }
    }

    /**
     * Get a post by its ID
     *
     * Retrieves a post by its ID from the database.
     * The result is an array containing the post data or a JsonResponse in case of error.
     *
     * @param array $validated The validated data, containing the ID of the post to retrieve.
     * @return array|JsonResponse An array containing the post data or a JsonResponse in case of error.
     */
    public function getById(array $validated): array|JsonResponse
    {
        $id = $validated['id'];
        try {
            return $this->model::with('author')
            ->find($id)
            ->toArray();
        } catch (\Exception $e) {
            Log::error('Failed to get post by ID', [
                'id' => $id,
                'message' => $e->getMessage()
            ]);
            return JsonResponseHelper::error(null, 'Failed to get post by ID');
        }
    }

    public function trashed(User|Authenticatable $user): array|JsonResponse
    {
        try {
            return $this->model::onlyTrashed()->get()->toArray();
        } catch (\Exception $e) {
            Log::error('Failed to get trashed posts', [
                'user_id' => $user->id,
                'message' => $e->getMessage(),
            ]);
            return JsonResponseHelper::error(null, 'Failed to get trashed posts');
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
     * @param int $postId The ID of the post to update.
     * @return Post|JsonResponse The updated post or an error response.
     */
    public function update(array $data, int $postId): Post|JsonResponse
    {
        try {
            $result = null;

            DB::transaction(function () use ($data, $postId, &$result) {
                $result = $this->model::find($postId);

                $updates = Arr::except($data, ['slug', 'tag_ids', 'category_ids']);

                if (count($updates)) {
                    $result->update($updates);
                }

                if (array_key_exists('tag_ids', $data) && count($data['tag_ids'])) {
                    $result->tags()->sync($data['tag_ids']);
                }

                if (array_key_exists('category_ids', $data) && count($data['category_ids'])) {
                    $result->categories()->sync($data['category_ids']);
                }

                $result->touch();
            });

            return $result;
        } catch (\Exception $e) {
            Log::error('Failed to update post', [
                'id' => $postId,
                'data' => $data,
                'message' => $e->getMessage()
            ]);

            return JsonResponseHelper::error(null, 'Failed to update post');
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
