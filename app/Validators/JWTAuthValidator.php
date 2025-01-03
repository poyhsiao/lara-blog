<?php

namespace App\Validators;

use App\Helper\JsonResponseHelper;
use App\Models\User;
use App\Validators\BaseValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JWTAuthValidator extends BaseValidator
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Validate register request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|JsonResponse
     */
    public function register(Request $request): array|JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|between:2,255|unique:users,name',
            'email' => 'required|email|max:255|unique:users,email',
            'display_name' => 'string|between:2,255|unique:users,display_name',
            'password' => 'required|string|min:8,255',
            'gender' => 'required|in:0,1,2',
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::notAcceptable('Register failed', $validated->errors());
        }

        return $validated->validated();
    }

    /**
     * Validate login request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|JsonResponse
     */
    public function login(Request $request): array|JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'user' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::error('Invalid data', $validated->errors());
        }

        return $validated->validated();
    }

    /**
     * Validate forget password request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|JsonResponse
     */
    public function forgetPassword(Request $request): array|JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'user' => 'required|string',
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::error('Invalid data', $validated->errors());
        }

        return $validated->validated();
    }

    /**
     * Validate reset password request.
     *
     * Validates the provided user and code for resetting the password.
     * Returns the validated data if successful, otherwise returns a JsonResponse
     * with an error message indicating invalid data.
     *
     * @param \Illuminate\Http\Request $request The request object containing user and code data.
     * @return array|JsonResponse The validated data or a JsonResponse with validation errors.
     */
    public function resetPassword(Request $request): array|JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'user' => [
                'required',
                'string',
                'between:2:255',
            ],
            'code' => [
                'required',
                'string',
                'size:7',
            ],
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::error(null, 'Invalid data');
        }

        return $validated->validated();
    }

    /**
     * Validate new password request.
     *
     * Validates the provided password and confirm password data for updating the user's
     * password. Returns the validated data if successful, otherwise returns a JsonResponse
     * with an error message indicating invalid data.
     *
     * @param \Illuminate\Http\Request $request The request object containing password and confirm password data.
     * @return array|JsonResponse The validated data or a JsonResponse with validation errors.
     */
    public function newPassword(Request $request): array|JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'user' => 'required|string|between:2:255',
            'password' => 'required|string|min:8|max:255',
            'confirm_password' => 'required|string|same:password',
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::error(null, 'Invalid data');
        }

        return $validated->validated();
    }

    /**
     * Validate email verification request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|JsonResponse
     */
    public function emailVerificationRequest(Request $request): array|JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'user' => 'required|string|between:2,255',
            'code' => 'required|string|size:7',
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::error(null, 'Invalid data');
        }

        return $validated->validated();
    }

    /**
     * Validate re-send email verification request.
     *
     * Validates the provided user and password for re-sending the email verification.
     * Returns the validated data if successful, otherwise returns a JsonResponse
     * with an error message indicating invalid data.
     *
     * @param \Illuminate\Http\Request $request The request object containing user and password data.
     * @return array|JsonResponse The validated data or a JsonResponse with validation errors.
     */
    public function reSendEmailVerify(Request $request): array|JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'user' => 'required|string|between:2,255',
            'password' => 'required|string|between:8,255',
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::error(null, 'Invalid data');
        }

        return $validated->validated();
    }
}
