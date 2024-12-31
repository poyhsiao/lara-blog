<?php

namespace App\Validators\Admin;

use App\Helper\JsonResponseHelper;
use App\Models\User;
use App\Validators\BaseValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdminUserValidator extends BaseValidator
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Validate the request for retrieving user details.
     *
     * Validates the 'user' field in the request data to ensure it is provided.
     * Returns a JSON response with errors if validation fails, otherwise returns
     * the validated data.
     *
     * @param \Illuminate\Http\Request $request The request object containing user data.
     * @return array|JsonResponse The validated data or a JsonResponse with validation errors.
     */
    public function getUserDetail(Request $request): array|JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'user' => 'required',
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::error($validated->errors(), 'Invalid data');
        }

        return $validated->validated();
    }

    /**
     * Validate the request for retrieving a list of users.
     *
     * Validates the 'page', 'limit', 'order', 'detail', and 'desc' fields in the request data.
     * Returns a JSON response with errors if validation fails, otherwise returns the validated data.
     *
     * @param \Illuminate\Http\Request $request The request object containing pagination query parameters.
     * @return array|JsonResponse The validated data or a JsonResponse with validation errors.
     */
    public function getAllUsers(Request $request): array|JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'page' => 'integer|min:1',
            'limit' => 'integer|min:1',
            'order' => 'string',
            'detail' => 'integer|in:0,1',
            'desc' => 'integer|in:0,1',
        ]);

        if ($validator->fails()) {
            return JsonResponseHelper::error($validator->errors(), 'Invalid data');
        }


        $page = (int) $validator->validated()['page'] ?? 1;
        $limit = (int) $validator->validated()['limit'] ?? 10;
        $order = (string) $validator->validated()['order'] ?? 'id';
        $detail = (bool) $validator->validated()['detail'] ?? false;
        $desc = (bool) $validator->validated()['desc'] ?? false;

        return compact('page', 'limit', 'order', 'detail', 'desc');
    }

    /**
     * Validate the request for updating a user's profile.
     *
     * Validates the 'name', 'email', 'display_name', and 'gender' fields in the request data.
     * Checks for uniqueness of 'name', 'email', and 'display_name' against the DB, ignoring the user with the given ID.
     * Returns a JSON response with errors if validation fails, otherwise returns the validated data.
     *
     * @param \Illuminate\Http\Request $request The request object containing user profile data.
     * @param array $user The user data.
     * @return array|JsonResponse The validated data or a JsonResponse with validation errors.
     */
    public function updateUserProfile(Request $request, array $user): array|JsonResponse
    {
        $userId = $this->hashToId($user['id']);

        if (!$userId) {
            return JsonResponseHelper::notFound('User not found');
        }

        $validated = Validator::make($request->all(), [
            'name' => [
                'string',
                'between:2,255',
                Rule::unique('users', 'name')->ignore($userId),
            ],
            'email' => [
                'string',
                'email',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'display_name' => [
                'string',
                'between:2,255',
                Rule::unique('users', 'display_name')->ignore($userId),
            ],
            'gender' => 'enum:0,1,2',
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::error($validated->errors(), 'Invalid data');
        }

        return $validated->validated();
    }

    /**
     * Validates the request for setting a user's password.
     *
     * Returns a JSON response with errors if validation fails, otherwise returns the validated data.
     *
     * @param \Illuminate\Http\Request $request The request object containing the new password.
     * @return array|JsonResponse The validated data or a JsonResponse with validation errors.
     */
    public function setPassword(Request $request): array|JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'password' => 'required|string|between:8,255',
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::error($validated->errors(), 'Invalid data');
        }

        return $validated->validated();
    }

    /**
     * Validate the request for setting a user's verification status.
     *
     * Ensures that the 'verify' field in the request data is provided and contains a valid value (0 or 1).
     * Returns a JSON response with errors if validation fails, otherwise returns the validated data.
     *
     * @param \Illuminate\Http\Request $request The request object containing the verification status.
     * @return array|JsonResponse The validated data or a JsonResponse with validation errors.
     */
    public function setVerify(Request $request): array|JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'verify' => 'required|in:0,1',
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::error($validated->errors(), 'Invalid data');
        }

        return $validated->validated();
    }

    /**
     * Validate the request for setting a user's active status.
     *
     * Ensures that the 'active' field in the request data is provided and contains a valid value (0 or 1).
     * Returns a JSON response with errors if validation fails, otherwise returns the validated data.
     *
     * @param \Illuminate\Http\Request $request The request object containing the active status.
     * @return array|JsonResponse The validated data or a JsonResponse with validation errors.
     */
    public function setActive(Request $request): array|JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'active' => 'required|in:0,1',
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::error($validated->errors(), 'Invalid data');
        }

        return $validated->validated();
    }

    /**
     * Validate the request for setting a user's trashed status.
     *
     * Ensures that the 'trash' field in the request data is provided and contains a valid value (0 or 1).
     * Returns a JSON response with errors if validation fails, otherwise returns the validated data.
     *
     * @param \Illuminate\Http\Request $request The request object containing the trashed status.
     * @return array|JsonResponse The validated data or a JsonResponse with validation errors.
     */
    public function setTrash(Request $request): array|JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'trash' => 'required|in:0,1',
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::error($validated->errors(), 'Invalid data');
        }

        return $validated->validated();
    }
}
