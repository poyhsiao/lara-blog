<?php

namespace App\Http\Controllers;

use App\Helper\JsonResponseHelper;
use App\Repositories\AuthRepository;
use App\Validators\JWTAuthValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTAuthController extends Controller
{
    private $validator;

    private $repo;

    public function __construct(JWTAuthValidator $validator, AuthRepository $repo)
    {
        $this->validator = $validator;
        $this->repo = $repo;
    }

    /**
     * User register
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $validated = $this->validator->register($request);

        if ($validated instanceof JsonResponse) {
            return $validated;
        }

        $result = $this->repo->register($validated);

        return $this->repoResponse($result, 'Register successfully');
    }

    /**
     * User Login
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $validated = $this->validator->login($request);

        if ($this->isJsonResponse($validated)) {
            return $validated;
        }

        $result = $this->repo->login($validated);

        return $this->repoResponse($result, 'Login successfully');
    }

    /**
     * Handle forget password request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function forgetPassword(Request $request): JsonResponse
    {
        $validated = $this->validator->forgetPassword($request);

        if ($this->isJsonResponse($validated)) {
            return $validated;
        }

        $result = $this->repo->forgetPassword($validated);

        return JsonResponseHelper::success($result, 'Forget password successfully');
    }

    /**
     * Reset password
     *
     * Resets the user's password if the provided information is valid.
     * Returns a JSON response indicating the result of the operation.
     *
     * @param \Illuminate\Http\Request $request The request object containing user and code data.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the success or error message.
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $validated = $this->validator->resetPassword($request);

        if ($this->isJsonResponse($validated)) {
            return $validated;
        }

        $result = $this->repo->resetPassword($validated);

        return $this->repoResponse($result, 'Reset password process successfully');
    }

    /**
     * Update new password
     *
     * Validates the request and updates the user's password if validation is successful.
     * Returns a JSON response indicating the result of the operation.
     *
     * @param \Illuminate\Http\Request $request The request object containing password and confirm password data.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the success or error message.
     */
    public function newPassword(Request $request): JsonResponse
    {
        $validate = $this->validator->newPassword($request);

        if ($this->isJsonResponse($validate)) {
            return $validate;
        }

        $result = $this->repo->newPassword($validate);

        return $this->repoResponse($result, 'Update new password process successfully');
    }

    /**
     * Get myself information
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMe(): JsonResponse
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return JsonResponseHelper::notFound('User not found');
            }
        } catch (\Exception $e) {
            return JsonResponseHelper::error(null, 'Invalid token');
        }

        return JsonResponseHelper::success(compact('user'), 'Get user successfully');
    }

    /**
     * Logout
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): JsonResponse
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            return JsonResponseHelper::success(null, 'Logout successfully');
        } catch (\Exception $e) {
            return JsonResponseHelper::error(null, 'Logout failed');
        }
    }

    /**
     * Handle email verification request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function emailVerificationRequest(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $this->validator->emailVerificationRequest($request);

        if ($this->isJsonResponse($validated)) {
            return $validated;
        }

        $result = $this->repo->emailVerification($validated->validated());

        return $this->repoRedirect($result, 'Email verification successfully');
    }

    /**
     * Handle re-sending of email verification.
     *
     * Validates the request and attempts to re-send the email verification
     * to the user. Returns a JSON response or redirect response indicating
     * the result of the operation.
     *
     * @param \Illuminate\Http\Request $request The request object containing user data.
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse A response indicating success or failure.
     */
    public function reSendEmailVerify(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $this->validator->reSendEmailVerify($request);

        if ($this->isJsonResponse($validated)) {
            return $validated;
        }

        $result = $this->repo->reSendEmailVerify($validated);

        return $this->repoRedirect($result, 'Resent email verification successfully');
    }
}
