<?php

namespace App\Http\Controllers;

use App\Helper\JsonResponseHelper;
use App\Repositories\CategoryRepository;
use App\Validators\CategoryValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CategoryController extends Controller
{
    public function __construct(CategoryRepository $repo, CategoryValidator $validator)
    {
        $this->repo = $repo;
        $this->validator = $validator;
    }

    /**
     * Get all categories
     *
     * Get all categories from the database.
     *
     * @return JsonResponse The response containing all categories or an error response
     */
    public function index(): JsonResponse
    {
        $result = $this->repo->index();

        if ($result instanceof JsonResponse) {
            return $result;
        }

        return JsonResponseHelper::success($result, 'Get categories successfully');
    }

    public function getById(int $id): JsonResponse
    {
        $validated = $this->validator::getById($id);

        if ($validated instanceof JsonResponse) {
            return $validated;
        }

        $result = $this->repo->getById($validated);

        if ($result instanceof JsonResponse) {
            return $result;
        }

        return JsonResponseHelper::success($result,'Get category successfully');
    }

    /**
     * Get all trashed categories
     *
     * Get all trashed categories from the database.
     *
     * @return JsonResponse The response containing all trashed categories or an error response
     */
    public function indexTrashed(): JsonResponse
    {
        $result = $this->repo->trashed();

        if ($result instanceof JsonResponse) {
            return $result;
        }

        return JsonResponseHelper::success($result,'Get categories successfully');
    }

    /**
     * Create a new category
     *
     * Validates the request using the CategoryValidator. If validation fails, returns a JsonResponse with the validation errors. Otherwise, attempts to create the category using the CategoryRepository. If the creation fails, returns an error response. Otherwise, returns a success response with the created category.
     *
     * @param \Illuminate\Http\Request $request The request object containing the category information
     * @return \Illuminate\Http\JsonResponse A JSON response containing the result of the operation
     */
    public function create(Request $request): JsonResponse
    {
        $validated = $this->validator::create($request);

        if ($validated instanceof JsonResponse) {
            return $validated;
        }

        $result = $this->repo->create($validated);

        if ($result instanceof JsonResponse) {
            return $result;
        }

        return JsonResponseHelper::success($result, 'Create category successfully');
    }

    /**
     * Update a category
     *
     * Validates the request using the CategoryValidator. If validation fails, returns a JsonResponse with the validation errors.
     * Otherwise, attempts to update the category using the CategoryRepository. If the update fails, returns an error response. Otherwise, returns a success response with the updated category.
     *
     * @param \Illuminate\Http\Request $request The request object containing the category information
     * @param int $id The ID of the category to update
     * @return \Illuminate\Http\JsonResponse A JSON response containing the result of the operation
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $this->validator::update($request, $id);

        if ($validated instanceof JsonResponse) {
            return $validated;
        }

        $id = $validated['id'];

        $updates = Arr::except($validated, ['id']);

        $result = $this->repo->update($updates, $id);

        if ($result instanceof JsonResponse) {
            return $result;
        }

        return JsonResponseHelper::success($result, 'Update category successfully');
    }

    /**
     * Delete a category
     *
     * Validates the request using the CategoryValidator. If validation fails, returns a JsonResponse with the validation errors.
     * Otherwise, attempts to delete the category using the CategoryRepository. If the delete fails, returns an error response. Otherwise, returns a success response with the deleted category.
     *
     * @param int $id The ID of the category to delete
     * @return \Illuminate\Http\JsonResponse A JSON response containing the result of the operation
     */
    public function delete(int $id): JsonResponse
    {
        $validated = $this->validator->delete($id);

        if ($validated instanceof JsonResponse) {
            return $validated;
        }

        $result = $this->repo->delete($id);

        if ($result instanceof JsonResponse) {
            return $result;
        }

        return JsonResponseHelper::success($result, 'Delete category successfully');
    }

    /**
     * Restore a deleted category
     *
     * Validates the request using the CategoryValidator. If validation fails, returns a JsonResponse with the validation errors.
     * Otherwise, attempts to restore the category using the CategoryRepository. If the restore fails, returns an error response. Otherwise, returns a success response with the restored category.
     *
     * @param int $id The ID of the category to restore
     * @return \Illuminate\Http\JsonResponse A JSON response containing the result of the operation
     */
    public function restore(int $id): JsonResponse
    {
        $validated = $this->validator->restore($id);

        if ($validated instanceof JsonResponse) {
            return $validated;
        }

        $result = $this->repo->restore($id);

        if ($result instanceof JsonResponse) {
            return $result;
        }

        return JsonResponseHelper::success($result, 'Restore category successfully');
    }
}
