<?php

namespace App\Swaggers;

use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class JWTAuthControllerAnnotation extends ControllerAnnotation
{
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
     */
    public function register(Request $request)
    {
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
     */
    public function login(Request $request)
    {
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
     */
    public function getMe(Request $request)
    {
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
     */
    public function logout()
    {
    }

    /**
     * @OA\Patch (
     *     path="/api/v1/forget-password",
     *     operationId="forgetPassword",
     *     summary="Forget password",
     *     description="Forget password",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user"},
     *             @OA\Property(
     *                 property="user",
     *                 type="string",
     *                 example="user",
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
     *                 example=200,
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     example=1,
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="John Doe",
     *                 ),
     *                 @OA\Property(
     *                    property="email",
     *                    type="string",
     *                    example="QHs4o@example.com",
     *                 ),
     *                 @OA\Property(
     *                    property="display_name",
     *                    type="string",
     *                    example="John Doe",
     *                 ),
     *                 @OA\Property(
     *                     property="gender",
     *                     type="integer",
     *                     example=1,
     *                 ),
     *                 @OA\Property(
     *                    property="active",
     *                    type="integer",
     *                    example=1,
     *                 ),
     *                 @OA\Property(
     *                    property="role",
     *                    type="integer",
     *                    example=0,
     *                 ),
     *             ),
     *             @OA\Property(
     *                property="error",
     *                type="object",
     *                example=null,
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
     */
    public function forgetPassword()
    {
    }

    /**
     * @OA\Patch (
     *     path="/api/v1/reset-password",
     *     operationId="resetPassword",
     *     summary="Reset password",
     *     description="Reset password",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user", "code"},
     *             @OA\Property(
     *                 property="user",
     *                 type="string",
     *                 example="user",
     *             ),
     *             @OA\Property(
     *                 property="code",
     *                 type="string",
     *                 example="1234567",
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
     *                 example=200,
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     example=1,
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="John Doe",
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     example="johndoe@example.com",
     *                 ),
     *                 @OA\Property(
     *                     property="display_name",
     *                     type="string",
     *                     example="John Doe",
     *                 ),
     *                 @OA\Property(
     *                     property="gender",
     *                     type="integer",
     *                     example=1,
     *                 ),
     *                 @OA\Property(
     *                    property="active",
     *                    type="integer",
     *                    example=1,
     *                 ),
     *                 @OA\Property(
     *                    property="role",
     *                    type="integer",
     *                    example=0,
     *                 ),
     *             ),
     *             @OA\Property(
     *                property="error",
     *                type="object",
     *                example=null,
     *             ),
     *         ),
     *    ),
     *   @OA\Response(
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
     */
    public function resetPassword()
    {
    }

    /**
     * @OA\Patch (
     *    path="/api/v1/new-password",
     *    operationId="newPassword",
     *    summary="New password",
     *    description="New password",
     *    tags={"Auth"},
     *    @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *            required={"user", "password", "confirm_password"},
     *            @OA\Property(
     *                property="user",
     *                type="string",
     *                example="user",
     *            ),
     *            @OA\Property(
     *                property="password",
     *                type="string",
     *                example="password",
     *            ),
     *            @OA\Property(
     *                property="confirm_password",
     *                type="string",
     *                example="password",
     *            ),
     *        ),
     *    ),
     *    @OA\Response(
     *        response=200,
     *        description="Success",
     *        @OA\JsonContent(
     *            @OA\Property(
     *                property="status_code",
     *                type="integer",
     *                example=200,
     *            ),
     *            @OA\Property(
     *                property="data",
     *                type="object",
     *                @OA\Property(
     *                    property="id",
     *                    type="integer",
     *                    example=1,
     *                ),
     *                @OA\Property(
     *                    property="name",
     *                    type="string",
     *                    example="John Doe",
     *                ),
     *                @OA\Property(
     *                    property="email",
     *                    type="string",
     *                    example="johndoe@example.com",
     *                ),
     *                @OA\Property(
     *                    property="display_name",
     *                    type="string",
     *                    example="John Doe",
     *                ),
     *                @OA\Property(
     *                    property="gender",
     *                    type="integer",
     *                    example=1,
     *                ),
     *                @OA\Property(
     *                    property="active",
     *                    type="integer",
     *                    example=1,
     *                ),
     *                @OA\Property(
     *                    property="role",
     *                    type="integer",
     *                    example=0,
     *                ),
     *            ),
     *            @OA\Property(
     *                property="error",
     *                type="object",
     *                example=null,
     *            ),
     *       ),
     *  ),
     *  @OA\Response(
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
     */
    public function newPassword()
    {
    }

    /**
     * @OA\Patch (
     *     path="/api/v1/verify-email",
     *     operationId="emailVerificationRequest",
     *     summary="Email Verification Request",
     *     description="Email Verification Request",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user", "code"},
     *             @OA\Property(
     *                 property="user",
     *                 type="string",
     *                 example="user",
     *             ),
     *             @OA\Property(
     *                 property="code",
     *                 type="string",
     *                 example="1234567",
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
     *                 example=200,
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="user",
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         example=1,
     *                     ),
     *                     @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example="John Doe",
     *                     ),
     *                     @OA\Property(
     *                         property="email",
     *                         type="string",
     *                         example="johndoe@example.com",
     *                     ),
     *                     @OA\Property(
     *                         property="display_name",
     *                         type="string",
     *                         example="John Doe",
     *                     ),
     *                     @OA\Property(
     *                         property="gender",
     *                         type="integer",
     *                         example=1,
     *                     ),
     *                     @OA\Property(
     *                         property="active",
     *                         type="integer",
     *                         example=1,
     *                     ),
     *                     @OA\Property(
     *                         property="role",
     *                         type="integer",
     *                         example=0,
     *                     ),
     *                ),
     *                @OA\Property(
     *                    property="token",
     *                    type="string",
     *                    example="xxxxxxxxx",
     *                ),
     *                @OA\Property(
     *                    property="type",
     *                    type="string",
     *                    example="Bearer",
     *                ),
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 example=null,
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
     */
    public function emailVerificationRequest() {}

    /**
     * @OA\Post(
     *     path="/api/v1/resend-email-verify",
     *     operationId="reSendEmailVerify",
     *     summary="Resend Email Verification",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user", "password"},
     *             @OA\Property(
     *                 property="user",
     *                 type="string",
     *                 example="user",
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 example="password",
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
     *                 example=200,
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     example=1,
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="John Doe",
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     example="johndoe@example.com",
     *                 ),
     *                 @OA\Property(
     *                     property="display_name",
     *                     type="string",
     *                     example="John Doe",
     *                 ),
     *                 @OA\Property(
     *                     property="gender",
     *                     type="integer",
     *                     example=1,
     *                 ),
     *                 @OA\Property(
     *                     property="active",
     *                     type="integer",
     *                     example=1,
     *                 ),
     *                 @OA\Property(
     *                     property="role",
     *                     type="integer",
     *                     example=1,
     *                 ),
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 example=null,
     *             ),
     *         ),
     *     ),
     *          @OA\Response(
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
     */
    public function reSendEmailVerify() {}
}
