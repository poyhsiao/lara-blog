<?php

namespace App\Repositories;

use App\Helper\JsonResponseHelper;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TagRepository extends BaseRepository
{
    protected $model;

    public function __construct(Tag $model)
    {
        $this->model = $model;
    }

    /**
     * Get all tags
     *
     * Get all tags from the database.
     * The result is an array of tags.
     *
     * @return array|JsonResponse An array of tags or a JsonResponse in case of error
     */
    public function index(): array|JsonResponse
    {
        try {
            return $this->model::all()->toArray();
        } catch (\Exception $e) {
            Log::error('Fail to get tags', ['message' => $e->getMessage()]);
            return JsonResponseHelper::error(null, 'Fail to get tags');
        }
    }

    /**
     * Get a tag by its ID
     *
     * This method retrieves a tag by its ID from the database.
     * The result is a Tag object or a JsonResponse in case of error.
     *
     * @param int $id The ID of the tag to retrieve.
     * @return Tag|JsonResponse A Tag object or a JsonResponse in case of error.
     */
    public function getById(int $id): Tag|JsonResponse
    {
        try {
            return $this->model::with('posts')->find($id);
        } catch (\Exception $e) {
            Log::error('Fail to get tag', [
                'id' => $id,
                'message' => $e->getMessage()
            ]);
            return JsonResponseHelper::error(null, 'Fail to get tag');
        }
    }

    /**
     * Get all soft-deleted tags
     *
     * Retrieve all soft-deleted tags from the database.
     * The result is an array of soft-deleted tags.
     *
     * @return array|JsonResponse An array of soft-deleted tags or a JsonResponse in case of error
     */
    public function trashed(): array|JsonResponse
    {
        try {
            return $this->model::onlyTrashed()->get()->toArray();
        } catch (\Exception $e) {
            Log::error('Fail to get trashed tags', [
                'message' => $e->getMessage()
            ]);
            return JsonResponseHelper::error(null, 'Fail to get trashed tags');
        }
    }

    /**
     * Create a new tag
     *
     * Attempts to create a new tag in the database.
     * The result is a Tag object or a JsonResponse in case of error.
     *
     * @param array $data The data to create the tag with.
     * @return Tag|JsonResponse A Tag object or a JsonResponse in case of error.
     */
    public function create(array $data): Tag|JsonResponse
    {
        $result = null;

        try {
            DB::transaction(function () use ($data, &$result) {
                $result = $this->model::create($data);
            });

            return $result;
        } catch (\Exception $e) {
            Log::error('Fail to create tag', [
                'data' => $data,
                'message' => $e->getMessage()
            ]);
            return JsonResponseHelper::error(null, 'Fail to create tag');
        }
    }

    /**
     * Update a tag
     *
     * Updates a tag with the given ID in the database. Validation of the request data is handled by the TagValidator. If the update fails, an error response is returned.
     *
     * @param int $id The ID of the tag to update
     * @param array $data The request data containing the tag information to update
     * @return Tag|JsonResponse The updated tag or an error response
     */
    public function update(int $id, array $data): Tag|JsonResponse
    {
        $result = null;

        try {
            DB::transaction(function () use ($id, $data, &$result) {
                $result = tap($this->model::find($id))->update($data);
            });

            return $result;
        } catch (\Exception $e) {
            Log::error('Fail to update tag', [
                'id' => $id,
                'data' => $data,
                'message' => $e->getMessage()
            ]);

            return JsonResponseHelper::error(null, 'Fail to update tag');
        }
    }

    /**
     * Delete a tag
     *
     * Deletes a tag with the given ID from the database.
     * If the deletion is successful, the deleted tag is returned. If an exception occurs, an error response is returned.
     *
     * @param int $id The ID of the tag to delete
     * @return Tag|JsonResponse The deleted tag, or an error response if the tag is not found or if an error occurs
     */
    public function delete(int $id): Tag|JsonResponse
    {
        try {
            $tag = $this->model::find($id);

            if (!$tag) {
                return JsonResponseHelper::error(null, 'Tag not found');
            }

            DB::transaction(function () use ($tag) {
                $tag->delete();
            });

            return $tag;
        } catch (\Exception $e) {
            Log::error('Failed to delete tag', [
                'id' => $id,
                'message' => $e->getMessage(),
            ]);

            return JsonResponseHelper::error(null, 'Failed to delete tag');
        }
    }

    /**
     * Restore a soft-deleted tag.
     *
     * Attempts to restore a tag with the given ID from the database. If the tag
     * is successfully restored, it returns the restored tag. If the tag is not found
     * or an exception occurs, an error response is returned.
     *
     * @param int $id The ID of the tag to restore.
     * @return Tag|JsonResponse The restored tag, or an error response if the tag is not found or if an error occurs.
     */
    public function restore(int $id): Tag|JsonResponse
    {
        try {
            $tag = $this->model::onlyTrashed()->find($id);

            if (!$tag) {
                return JsonResponseHelper::error(null, 'Tag not found');
            }

            DB::transaction(function () use ($tag) {
                $tag->restore();
            });

            return $tag;
        } catch (\Exception $e) {
            Log::error('Failed to restore tag', [
                'id' => $id,
                'message' => $e->getMessage(),
            ]);

            return JsonResponseHelper::error(null, 'Failed to restore tag');
        }
    }
}
