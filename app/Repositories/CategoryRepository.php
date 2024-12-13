<?php

namespace App\Repositories;

use App\Helper\JsonResponseHelper;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoryRepository extends Repository
{
    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    /**
     * Retrieve all categories from the database.
     *
     * This method retrieves all categories and their associated posts from the database.
     * The result is an array of categories, each containing a nested array of posts.
     *
     * @return array|JsonResponse An array of categories or a JsonResponse in case of error
     */
    public function index(): array|JsonResponse
    {
        try {
            return $this->model::with(['posts', 'childCategories'])
              ->get()
              ->toArray();
        } catch (\Exception $e) {
            Log::error('Failed to get categories', [
                'message' => $e->getMessage(),
            ]);
            return JsonResponseHelper::error(null, 'Failed to get categories');
        }
    }

    /**
     * Retrieve a category by its ID.
     *
     * This method retrieves a category and its associated child categories from the database.
     * The result is a Category object or a JsonResponse in case of error.
     *
     * @param int $id The ID of the category to retrieve.
     * @return Category|JsonResponse A Category object or a JsonResponse in case of error.
     */
    public function getById(int $id): Category|JsonResponse
    {
        try {
            return $this->model::with('children')->find($id);
        } catch (\Exception $e) {
            Log::error('Failed to get category by ID', [
                'id' => $id,
                'message' => $e->getMessage(),
            ]);
            return JsonResponseHelper::error(null, 'Failed to get category by ID');
        }
    }

    /**
     * Retrieve all soft-deleted categories.
     *
     * This method retrieves all categories that have been soft-deleted from the database.
     * It returns an array of these trashed categories. If an error occurs during retrieval,
     * a JsonResponse with an error message is returned.
     *
     * @return array|JsonResponse An array of soft-deleted categories or a JsonResponse in case of error
     */
    public function trashed(): array|JsonResponse
    {
        try {
            return $this->model::onlyTrashed()->get()->toArray();
        } catch (\Exception $e) {
            Log::error('Failed to get categories', [
                'message' => $e->getMessage(),
            ]);
            return JsonResponseHelper::error(null, 'Failed to get categories');
        }
    }

    /**
     * Create a new category
     *
     * Creates a new category in the database. Validation of the request data is handled by the CategoryValidator. If the creation fails, an error response is returned.
     *
     * @param array $data The request data containing the category information
     * @return Category|JsonResponse The created category or an error response
     */
    public function create(array $data): Category|JsonResponse
    {
        $result = null;

        try {
            DB::transaction(function () use ($data, &$result) {
                $result = $this->model::create($data);
            });

            return $result;
        } catch (\Exception $e) {
            Log::error('Failed to create category', [
                'message' => $e->getMessage(),
            ]);
            return JsonResponseHelper::error(null, 'Failed to create category');
        }
    }

    /**
     * Update a category
     *
     * Updates a category with the given ID in the database. Validation of the request data is handled by the CategoryValidator. If the update fails, an error response is returned.
     *
     * @param array $data The request data containing the category information to update
     * @param int $id The ID of the category to update
     * @return Category|JsonResponse The updated category or an error response
     */
    public function update(array $data, int $id): Category|JsonResponse
    {
        $result = null;

        try {
            DB::transaction(function () use ($data, $id, &$result) {
                $result = tap($this->model::find($id))->update($data);
            });

            return $result;
        } catch (\Exception $e) {
            Log::error('Failed to update category', [
                'id' => $id,
                'message' => $e->getMessage(),
            ]);
            return JsonResponseHelper::error(null, 'Failed to update category');
        }
    }

    /**
     * Delete a category
     *
     * Deletes a category with the given ID. If the category is found and the deletion is successful, the deleted category is returned. If an exception occurs, an error response is returned.
     *
     * @param int $id The ID of the category to delete
     * @return Category|JsonResponse The deleted category, or an error response if the category is not found or if an error occurs
     */
    public function delete(int $id): Category|JsonResponse
    {
        $result = null;

        try {
            DB::transaction(function () use ($id, &$result) {
                $result = tap($this->model::find($id))->delete();
            });

            return $result;
        } catch (\Exception $e) {
            Log::error('Failed to delete category', [
                'id' => $id,
                'message' => $e->getMessage(),
            ]);
            return JsonResponseHelper::error(null, 'Failed to delete category');
        }
    }

    /**
     * Restore a deleted category.
     *
     * Attempts to restore a category with the given ID from the database. If the category is successfully restored, it returns the restored category. If an exception occurs, an error response is returned.
     *
     * @param int $id The ID of the category to restore.
     * @return Category|JsonResponse The restored category, or an error response if the category is not found or if an error occurs.
     */
    public function restore(int $id): Category|JsonResponse
    {
        $result = null;

        try {
            DB::transaction(function () use ($id, &$result) {
                $result = tap($this->model::withTrashed()->find($id))->restore();
            });

            return $result;
        } catch (\Exception $e) {
            Log::error('Failed to restore category', [
                'id' => $id,
                'message' => $e->getMessage(),
            ]);
            return JsonResponseHelper::error(null, 'Failed to restore category');
        }
    }
}
