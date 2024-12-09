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
     * @OA\Post(
     *     path="/api/v1/register",
     *     operationId="register",
     *     summary="User register",
     *     description="User register",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password", "gender"},
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="John"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     example="QHs4o@example.com"
     *                 ),
     *                 @OA\Property(
     *                     property="display_name",
     *                     type="string",
     *                     example="John Doe"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     example="password"
     *                 ),
     *                 @OA\Property(
     *                     property="gender",
     *                     type="integer",
     *                     example=1
     *                 ),
     *           ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status_code",
     *                 type="integer",
     *                 example=200
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 example={
     *                         "message": "Register successfully",
     *                         "data": {
     *                             "user": {
     *                                 "id": 1,
     *                                 "name": "John Doe",
     *                                 "email": "QHs4o@example.com",
     *                                 "display_name": "John Doe",
     *                                 "gender": 1
     *                             },
     *                             "token": "xxxxxxxxx",
     *                             "type": "Bearer"
     *                         }
     *                     }
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 example=null
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status_code",
     *                 type="integer",
     *                 example=400
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 example=null
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 example={
     *                     "message": "Invalid data",
     *                     "errors": {
     *                         "name": {
     *                             "The name field is required."
     *                         },
     *                         "email": {
     *                             "The email field is required."
     *                         },
     *                         "display_name": {
     *                             "The display name field is required."
     *                         },
     *                         "password": {
     *                             "The password field is required."
     *                         },
     *                         "gender": {
     *                             "The gender field is required."
     *                         }
     *                     }
     *                 }
     *             ),
     *         ),
     *     ),
     * )
     *
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

        return JsonResponseHelper::success('Register successfully', compact('user', 'token', 'type'));
    }

    /**
     * @OA\Post(
     *     path="/api/v1/login",
     *     summary="User Login",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Pass user credentials",
     *         @OA\JsonContent(
     *             required={"user", "password"},
     *             @OA\Property(
     *                 property="user",
     *                 oneOf={
     *                     @OA\Schema(
     *                         type="string",
     *                         description="Email",
     *                         example="QHs4o@example.com"
     *                     ),
     *                     @OA\Schema(
     *                         type="string",
     *                         description="Name",
     *                         example="John"
     *                     ),
     *                 }
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 example="password"
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status_code",
     *                 type="integer",
     *                 example=200
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 example={
     *                     "user": {
     *                         "id": 1,
     *                         "name": "John Doe",
     *                         "email": "QHs4o@example.com",
     *                         "display_name": "John Doe",
     *                         "gender": 1,
     *                         "active": 1,
     *                         "role": 0
     *                     },
     *                     "token": "xxxxxxxxx",
     *                     "type": "Bearer"
     *                 }
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 example=null
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status_code",
     *                 type="integer",
     *                 example=400
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 example=null
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 example={
     *                     "message": "Invalid data",
     *                     "errors": {
     *                         "user": {
     *                             "The user field is required."
     *                         },
     *                         "password": {
     *                             "The password field is required."
     *                         }
     *                     }
     *                 }
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status_code",
     *                 type="integer",
     *                 example=401
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 example=null
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 example={
     *                     "message": "Login failed",
     *                     "errors": {
     *                         "user": {
     *                             "Invalid username or password"
     *                         }
     *                     }
     *                 }
     *             ),
     *         ),
     *     ),
     * )
     *
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
                return JsonResponseHelper::error( ['data' => 'Invalid username or password'], 'Login failed');
            }

            $user = Auth::user();
            $type = 'Bearer';

            /**
             * User is not active or email is not verified
             */
            if ($user->active === 0 || $user->email_verified_at === null) {
                return JsonResponseHelper::unauthorized('The user is not active or email is not verified');
            }

            return JsonResponseHelper::success('Login successfully', compact('user', 'token', 'type'));
        } catch (\Exception $e) {
            return JsonResponseHelper::error(['data' => $e->getMessage()], 'Login failed');
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/me",
     *     operationId="getMe",
     *     summary="Get myself information",
     *     description="Get myself information",
     *     tags={"Auth"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status_code",
     *                 type="integer",
     *                 example=200
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 example={
     *                     "message": "Get myself information successfully",
     *                     "user": {
     *                         "id": 1,
     *                         "name": "John Doe",
     *                         "email": "QHs4o@example.com",
     *                         "display_name": "John Doe",
     *                         "gender": 1,
     *                         "active": 1,
     *                         "role": 0,
     *                     }
     *                 }
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status_code",
     *                 type="integer",
     *                 example=401
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 example=null
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 example={
     *                     "message": "Invalid token",
     *                 }
     *             ),
     *         ),
     *     ),
     * )
     *
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

        return JsonResponseHelper::success('Get user successfully', compact('user'));
    }

    /**
     * @OA\Post(
     *     path="/api/v1/logout",
     *     operationId="logout",
     *     summary="Logout",
     *     description="Logout",
     *     tags={"Auth"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status_code",
     *                 type="integer",
     *                 example=200
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 example={
     *                     "message": "Logout successfully",
     *                 }
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status_code",
     *                 type="integer",
     *                 example=400
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 example=null
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 example={
     *                     "message": "Logout failed",
     *                 }
     *             ),
     *         ),
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status_code",
     *                 type="integer",
     *                 example=401
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 example=null
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 example={
     *                     "message": "Unauthorized",
     *                 }
     *             ),
     *         ),
     *     ),
     * )
     *
     * Logout
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): JsonResponse
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            return JsonResponseHelper::success('Logout successfully', null);
        } catch (\Exception $e) {
            return JsonResponseHelper::error(null, 'Logout failed');
        }
    }
}
