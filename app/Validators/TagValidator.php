<?php

namespace App\Validators;

use App\Helper\JsonResponseHelper;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TagValidator extends BaseValidator
{
    protected $model;

    public function __construct(Tag $model)
    {
        $this->model = $model;
    }

    /**
     * Validate the tag ID to get.
     *
     * This method checks if the provided ID exists in the tags table and is a valid numeric value. If validation fails, it returns a JsonResponse with the validation errors. Otherwise, it returns the validated ID as an integer.
     *
     * @param int $id The ID of the tag to get.
     * @return int|JsonResponse The validated ID as an integer or a JsonResponse with validation errors.
     */
    public function id(int $id): array|JsonResponse
    {
        $validated = Validator::make(compact('id'), [
            'id' => 'required|numeric|exists:tags,id',
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::notAcceptable('Get tag failed', $validated->errors());
        }

        return $validated->validated();
    }

    /**
     * Validate create tag request.
     *
     * This method validates the request data for creating a tag. It ensures:
     * - 'name' is required, a string, between 2 and 255 characters, and unique among tags.
     * - 'description' is a string and between 2 and 255 characters.
     * If validation fails, it returns a JsonResponse with the validation errors.
     * Otherwise, it returns the validated data.
     *
     * @param \Illuminate\Http\Request $request The request object containing tag data to create.
     * @return array|JsonResponse The validated data or a JsonResponse with validation errors.
     */
    public function create(Request $request): array|JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|between:2,255|unique:tags,name',
            'description' => 'string|between:2,255',
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::notAcceptable('Create tag failed', $validated->errors());
        }

        return $validated->validated();
    }

    /**
     * Validate update tag request.
     *
     * This method first validates the provided tag ID to ensure it exists.
     * If the ID validation fails, it returns a JsonResponse with the validation errors.
     * Then, it validates the tag update data from the request to ensure:
     * - the 'name' is required, a string, between 2 and 255 characters, and unique among tags.
     * - the 'description' is a string and between 2 and 255 characters.
     * If any validation fails, it returns a JsonResponse with the errors.
     * Otherwise, it returns the validated data.
     *
     * @param \Illuminate\Http\Request $request The request object containing tag data to update.
     * @param int $id The ID of the tag to update.
     * @return array|JsonResponse The validated data or a JsonResponse with validation errors.
     */
    public function update(Request $request, int $id): array|JsonResponse
    {
        $theId = self::id($id);

        if ($theId instanceof JsonResponse) {
            return $theId;
        }

        $validated = Validator::make($request->all(), [
            'name' => [
                'string',
                'between:2,255',
                Rule::unique('tags', 'name')->ignore($theId),
            ],
            'description' => [
                'string',
                'between:2,255',
            ],
        ], [
            'name.unique' => 'The tag name has already been taken',
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::notAcceptable('Update tag failed', $validated->errors());
        }

        return $validated->validated();
    }

    /**
     * Validate and authorize deletion of a tag.
     *
     * This method checks if the provided tag ID is valid and exists in the tags table.
     * If validation fails, it returns a JsonResponse with validation errors.
     * It also checks if the user performing the action is an admin.
     * If not, it returns a not authorized response.
     * If validation and authorization succeed, it returns the validated ID.
     *
     * @param int $tagId The ID of the tag to delete.
     * @param ?User $user The user performing the action. If not provided, the authenticated user is used.
     * @return array|JsonResponse The validated ID as an integer or a JsonResponse with validation errors.
     */
    public function delete(int $tagId, User|Authenticatable|null $user = null): array|JsonResponse
    {
        $user ??= Auth::user();

        $validator = Validator::make(['id' => $tagId], [
            'id' => 'required|numeric|exists:tags,id',
        ]);

        if ($validator->fails()) {
            return JsonResponseHelper::notAcceptable('Delete tag failed', $validator->errors());
        }

        if (!$user->isAdmin()) {
            return JsonResponseHelper::notAcceptable('You are not allowed to delete this tag');
        }

        return $validator->validated();
    }

    /**
     * Validate and authorize restoration of a tag.
     *
     * This method checks if the provided tag ID is valid and exists in the tags table.
     * If validation fails, it returns a JsonResponse with validation errors.
     * It also checks if the user performing the action is an admin.
     * If the user is not an admin, it returns a not authorized response.
     * If validation and authorization succeed, it returns the validated ID.
     *
     * @param int $tagId The ID of the tag to restore.
     * @param ?User $user The user performing the action. If not provided, the authenticated user is used.
     * @return array|JsonResponse The validated ID as an array or a JsonResponse with validation errors.
     */
    public function restore(int $tagId, User|Authenticatable|null $user = null): array|JsonResponse
    {
        $user ??= Auth::user();

        $validator = Validator::make(['id' => $tagId], [
            'id' => 'required|numeric|exists:tags,id',
        ]);

        if ($validator->fails()) {
            return JsonResponseHelper::notAcceptable('Restore tag failed', $validator->errors());
        }

        if (!$user->isAdmin()) {
            return JsonResponseHelper::notAcceptable('You do not have permission to restore this tag');
        }

        return $validator->validated();
    }
}
