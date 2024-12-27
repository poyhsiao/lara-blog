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

        if ($validated instanceof JsonResponse) {
            return $validated;
        }

        $result = $this->repo->login($validated);

        return $this->repoResponse($result, 'Login successfully');
    }

    public function forgetPassword(Request $request): JsonResponse
    {
        $validated = $this->validator->forgetPassword($request);

        if ($this->isJsonResponse($validated)) {
            return $validated;
        }

        $result = $this->repo->forgetPassword($validated);

        return $this->repoResponse($result, 'Reset password successfully');
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

        return $this->repoRedirect($result, 'email_verified');
    }
}
