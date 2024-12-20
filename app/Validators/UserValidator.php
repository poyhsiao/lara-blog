<?php

namespace App\Validators;

use App\Helper\JsonResponseHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserValidator
{
    /**
     * Validate change password request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|JsonResponse
     */
    public static function changePasswordValidate(Request $request): array|JsonResponse
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
    public static function updateProfileValidate(Request $request, int $id): array|JsonResponse
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
}
