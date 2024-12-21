<?php

namespace App\Validators;

use App\Helper\JsonResponseHelper;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserValidator extends BaseValidator
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Validate change password request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|JsonResponse
     */
    public function changePasswordValidate(Request $request): array|JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'password' => 'required|string|min:8',
            'new_password' => 'required|string|min:8|different:password',
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::notAcceptable('Change password failed', $validated->errors());
        }

        return $validated->validated();
    }

    /**
     * Validate update profile request.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return array|JsonResponse
     */
    public function updateProfileValidate(Request $request, int $id): array|JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'name' => [
                'string',
                'between:2,255',
                Rule::unique('users', 'name')->ignore($id),
            ],
            'email' => [
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($id),
            ],
            'display_name' => [
                'string',
                'between:2,255',
                Rule::unique('users', 'display_name')->ignore($id),
            ],
            'gender' => 'enum:0,1,2',
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::notAcceptable('Update profile failed', $validated->errors());
        }

        return $validated->validated();
    }

    /**
     * Validate get user by ID request.
     *
     * Validates the provided ID and the query parameters for getting user data.
     * If validation fails, returns a JsonResponse with the validation errors.
     * Otherwise, returns the validated data.
     *
     * @param \Illuminate\Http\Request $request The request object containing query parameters.
     * @param int $userId The ID of the user to retrieve.
     * @param \App\Models\User|\Illuminate\Contracts\Auth\Authenticatable $user The user attempting to get the user.
     * @return array|JsonResponse The validated data or a JsonResponse with validation errors or unauthorized response.
     */
    public function getById(Request $request, int $userId, User|Authenticatable $user): array|JsonResponse
    {
        $theId = $this->validateId($userId);

        if ($theId instanceof JsonResponse) {
            return $theId;
        }

        if (!$user->isAdmin() && $user->id !== $userId) {
            return JsonResponseHelper::notAcceptable('You are not authorized to get this user');
        }

        $validated = Validator::make($request->all(), [
            'posts' => 'integer|in:0,1',
            'comments' => 'integer|in:0,1',
            'emotions' => 'integer|in:0,1',
            'emotionUsers' => 'integer|in:0,1',
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::notAcceptable('Get user failed', $validated->errors());
        }

        $result = $validated->validated();
        $result['user_id'] = $theId;
        return $result;
    }

    /**
     * Validate get posts request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|JsonResponse
     */
    public function getPosts(Request $request): array|JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'filter' => 'string|in:all,trashed,draft,published',
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::notAcceptable('Get posts failed', $validated->errors());
        }

        return $validated->validated();
    }

    /**
     * Validate the user ID.
     *
     * This method checks if the provided ID is a valid numeric value and exists in the users table.
     * If validation fails, it returns a JsonResponse with the validation errors.
     * Otherwise, it returns the validated ID as an integer.
     *
     * @param int $userId The ID of the user to validate.
     * @return array|JsonResponse The validated ID as an integer or a JsonResponse with validation errors.
     */
    private function validateId(int $userId): array|JsonResponse
    {
        $validated = Validator::make(['id' => $userId], [
            'id' => 'required|numeric|exists:users,id',
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::notAcceptable('Get user failed', ['message' => $validated->errors()]);
        }

        return $validated->validated();
    }
}
