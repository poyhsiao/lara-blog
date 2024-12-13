<?php

namespace App\Http\Controllers;

use App\Helper\JsonResponseHelper;
use App\Repositories\UserRepository;
use App\Validators\UserValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $repo;

    public function __construct(UserRepository $repo, UserValidator $validator)
    {
        $this->repo = $repo;
        $this->validator = $validator;
    }

    /**
     * Get myself information
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(): JsonResponse
    {
        $user = Auth::user();

        return JsonResponseHelper::success($user, 'Get myself information successfully');
    }

    /**
     * Change the authenticated user's password.
     *
     * Validates the request and updates the user's password if validation is successful.
     * Returns a JSON response indicating the result of the operation.
     *
     * @param \Illuminate\Http\Request $request The request object containing the current and new password.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the success or error message.
     */
    public function changePassword(Request $request): JsonResponse
    {
        $validated = $this->validator::changePasswordValidate($request);

        if ($validated instanceof JsonResponse) {
            return $validated;
        }

        $user = $this->repo->changePassword(Auth::user(), $validated['password'], $validated['new_password']);

        if ($user instanceof JsonResponse) {
            return $user;
        }

        return JsonResponseHelper::success($user, 'Change password successfully');
    }

    /**
     * Update the authenticated user's profile information.
     *
     * Validates the request and updates the user's profile if validation is successful.
     * Returns a JSON response indicating the result of the operation.
     *
     * @param \Illuminate\Http\Request $request The request object containing profile data.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the success or error message.
     */
    public function updateProfile(Request $request)
    {
        if (!Auth::user()) {
            return JsonResponseHelper::notFound('User not found');
        }

        $user = Auth::user();

        $validate = $this->validator::updateProfileValidate($request, $user->id);

        if ($validate instanceof JsonResponse) {
            return $validate;
        }

        $user = $this->repo->updateProfile($user, $validate);

        if ($user instanceof JsonResponse) {
            return $user;
        }

        return JsonResponseHelper::success($user, 'Update profile successfully');
    }

    public function getPosts(Request $request): JsonResponse
    {
        $user = Auth::user();

        $validated = $this->validator::getPosts($request);

        if ($validated instanceof JsonResponse) {
            return $validated;
        }

        $posts = $this->repo->getPosts($user, $validated['filter'] ?? 'published');

        if ($posts instanceof JsonResponse) {
            return $posts;
        }

        return JsonResponseHelper::success($posts , 'Get ' . ($validated['filter'] ?? 'published') . ' posts successfully');
    }
}
