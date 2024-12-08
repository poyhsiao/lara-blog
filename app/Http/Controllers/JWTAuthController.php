<?php

namespace App\Http\Controllers;

use App\Repositories\AuthRepository;
use App\Services\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTAuthController extends Controller
{
    public function __construct(Service $service, AuthRepository $repo)
    {
        $this->service = $service;
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:users,name',
            'email' => 'required|email|max:255|unique:users,email',
            'display_name' => 'string|max:255|unique:users,display_name',
            'password' => 'required|string|min:8',
            'gender' => 'required|in:0,1,2',
        ]);

        if ($validator->fails()) {
            return $this->service->error('Invalid data', $validator->errors());
        }

        if (!$user = $this->repo->create($request->all())) {
            return $this->service->error('Register failed', $user);
        }

        $token = JWTAuth::fromUser($user);
        $type = 'Bearer';

        return $this->service->success('Register successfully', compact('user', 'token', 'type'));
    }

    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->service->error('Invalid data', $validator->errors());
        }

        try {
            if (!$token = JWTAuth::attempt([
                    'email' => $request->user,
                    'password' => $request->password,
                ])
            ) {
                $token = JWTAuth::attempt([
                    'name' => $request->user,
                    'password' => $request->password,
                ]);
            }

            /**
             * User name/email or password is incorrect
             */
            if (!$token) {
                return $this->service->error('Login failed', ['data' => 'Invalid username or password']);
            }

            $user = Auth::user();
            $type = 'Bearer';

            /**
             * User is not active or email is not verified
             */
            if ($user->active === 0 || $user->email_verified_at === null) {
                return $this->service->unauthorized('The user is not active or email is not verified');
            }

            return $this->service->success('Login successfully', compact('user', 'token', 'type'));
        } catch (\Exception $e) {
            return $this->service->error('Login failed', ['data' => $e->getMessage()]);
        }
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
                return $this->service->notFound('User not found');
            }
        } catch (\Exception $e) {
            return $this->service->error('Invalid token', null);
        }

        return $this->service->success('Get user successfully', compact('user'));
    }

    /**
     * Refresh token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refreshToken(): JsonResponse
    {
        try {
            $user = Auth::user();
            $authorization = [
                'token' => JWTAuth::refresh(),
                'type' => 'Bearer',
            ];
        } catch (\Exception $e) {
            return $this->service->error('Invalid token', ['message' => $e->getMessage()]);
        }

        return $this->service->success('Refresh token successfully', compact('user', 'authorization'));
    }

    /**
     * Logout
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): JsonResponse
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return $this->service->success('Logout successfully', null);
    }
}
