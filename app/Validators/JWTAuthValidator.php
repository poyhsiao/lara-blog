<?php

namespace App\Validators;

use App\Helper\JsonResponseHelper;
use App\Models\User;
use App\Rules\HashIdCheckRule;
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
     * Validate email verification request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|JsonResponse
     */
    public function emailVerificationRequest(Request $request): array|JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'u' => [
                'required',
                'string',
                'min:10',
                new HashIdCheckRule('email-validate', 'user', 'The user is not found'),
            ],
            'p' => [
                'required',
                'string',
                'min:10',
                new HashIdCheckRule('email-validate', 'expired_at', 'The validate time is expired'),
            ],
        ]);

        if ($validated->fails()) {
            return JsonResponseHelper::error(null, 'Invalid data');
        }

        return $validated->validated();
    }
}
