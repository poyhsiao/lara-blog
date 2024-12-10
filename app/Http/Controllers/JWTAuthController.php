<?php

namespace App\Http\Controllers;

use App\Helper\JsonResponseHelper;
use App\Repositories\AuthRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTAuthController extends Controller
{
    public function __construct(AuthRepository $repo)
    {
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
            return JsonResponseHelper::error('Invalid data', $validator->errors());
        }

        if (!$user = $this->repo->create($request->all())) {
            return JsonResponseHelper::error('Register failed', $user);
        }

        $token = JWTAuth::fromUser($user);
        $type = 'Bearer';

        return JsonResponseHelper::success(compact('user', 'token', 'type'), 'Register successfully');
    }

    /**
     * User Login
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return JsonResponseHelper::error('Invalid data', $validator->errors());
        }

        try {
            if (!$token = JWTAuth::attempt([
                'email' => $request->user,
                'password' => $request->password,
            ])) {
                $token = JWTAuth::attempt([
                    'name' => $request->user,
                    'password' => $request->password,
                ]);
            }

            /**
             * User name/email or password is incorrect
             */
            if (!$token) {
                return JsonResponseHelper::error(['data' => 'Invalid username or password'], 'Login failed');
            }

            $user = Auth::user();
            $type = 'Bearer';

            /**
             * User is not active or email is not verified
             */
            if ($user->active === 0 || $user->email_verified_at === null) {
                return JsonResponseHelper::unauthorized('The user is not active or email is not verified');
            }

            return JsonResponseHelper::success(compact('user', 'token', 'type'), 'Login successfully');
        } catch (\Exception $e) {
            return JsonResponseHelper::error(['data' => $e->getMessage()], 'Login failed');
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
}
