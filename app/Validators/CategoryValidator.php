<?php

namespace App\Validators;

use App\Helper\JsonResponseHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryValidator
{
    public static function getById(int $id): int|JsonResponse
    {
        return self::validateId($id);
    }

    /**
     * Validate create category request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|JsonResponse
     */
    public static function create(Request $request): array|JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|between:2,255|unique:categories,name',
            'slug' => 'required|string|between:2,255|unique:categories,slug',
            'description' => 'string|between:2,255',
            'parent' => 'integer|exists:categories,id',
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::notAcceptable($validated->errors());
        }

        return $validated->validated();
    }

    /**
     * Validate update category request.
     *
     * This method first validates the provided category ID to ensure it exists.
     * If the ID validation fails, it returns a JsonResponse with the validation errors.
     * Then, it validates the category update data from the request to ensure:
     * - the 'name' and 'slug' are strings, unique among categories, and between 2 and 255 characters.
     * - the 'description' is a string between 2 and 255 characters.
     * - the 'parent' is an integer, exists in categories, and is different from the current category ID.
     * If any validation fails, it returns a JsonResponse with the errors.
     * Otherwise, it returns the validated data.
     *
     * @param \Illuminate\Http\Request $request The request object containing category data to update.
     * @param int $id The ID of the category to update.
     * @return array|JsonResponse The validated data or a JsonResponse with validation errors.
     */
    public static function update(Request $request, int $id): array|JsonResponse
    {
        $theId = self::validateId($id);

        if ($theId instanceof JsonResponse) {
            return $theId;
        }

        $validated = Validator::make($request->all(), [
            'name' => [
                'string',
                'between:2,255',
                Rule::unique('categories', 'name')->ignore($theId),
            ],
            'slug' => [
                'string',
                'between:2,255',
                Rule::unique('categories', 'slug')->ignore($theId),
            ],
            'description' => 'string|between:2,255',
            'parent' => [
                'integer',
                'exists:categories,id',
                Rule::notIn($theId),
            ],
        ], [
            'parent.not_in' => 'The parent category cannot be the same as the current category.',
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::notAcceptable('Update category failed', $validated->errors());
        }

        return array_merge($validated->validated(), compact('id'));
    }

    /**
     * Validate the category ID to delete.
     *
     * This method checks if the provided ID exists in the categories table and is a valid numeric value. If validation fails, it returns a JsonResponse with the validation errors. Otherwise, it returns the validated ID as an integer.
     *
     * @param int $id The ID of the category to delete.
     * @return int|JsonResponse The validated ID as an integer or a JsonResponse with validation errors.
     */
    public static function delete(int $id): int|JsonResponse
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|numeric|exists:categories,id',
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::notAcceptable('Update category failed', $validated->errors());
        }

        return (int)$validated->validated()['id'];
    }

    /**
     * Validate the category ID to restore.
     *
     * This method is the same as validating the category ID to delete.
     *
     * @param int $id The ID of the category to restore.
     * @return int|JsonResponse The validated ID as an integer or a JsonResponse with validation errors.
     */
    public static function restore(int $id): int|JsonResponse
    {
        return self::delete($id);
    }

    /**
     * Validate the category ID.
     *
     * This method checks if the provided ID exists in the categories table and is a valid numeric value. If validation fails, it returns a JsonResponse with the validation errors. Otherwise, it returns the validated ID as an integer.
     *
     * @param int $id The ID of the category to validate.
     * @return int|JsonResponse The validated ID as an integer or a JsonResponse with validation errors.
     */
    private static function validateId(int $id): int|JsonResponse
    {
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|numeric|exists:categories,id',
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::notAcceptable('Update category failed', $validated->errors());
        }

        return (int)$validated->validated()['id'];
    }
}
