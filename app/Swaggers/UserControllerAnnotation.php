<?php

namespace App\Swaggers;

class UserControllerAnnotation extends ControllerAnnotation
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @OA\Get(
     *     path="/api/v1/user/me",
     *     operationId="userMe",
     *     tags={"User"},
     *     summary="Get myself information",
     *     description="Get myself information",
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
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="John Doe"
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
     *                     property="gender",
     *                     type="integer",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="active",
     *                     type="integer",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="role",
     *                     type="integer",
     *                     example=0
     *                 ),
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 example=null
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="400",
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
     *                 example=null,
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Invalid data"
     *                 ),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="401",
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
     *                 example=null,
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Unauthorized"
     *                 ),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not Found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status_code",
     *                 type="integer",
     *                 example=404
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 example=null,
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="User not found"
     *                 ),
     *             ),
     *         ),
     *     ),
     * )
     */
    public function me()
    {
    }

    /**
     * @OA\Patch(
     *     path="/api/v1/change-password",
     *     operationId="changePassword",
     *     summary="Change the authenticated user's password",
     *     description="Change the authenticated user's password",
     *     tags={"User"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 example="password",
     *             ),
     *             @OA\Property(
     *                 property="new_password",
     *                 type="string",
     *                 example="new_password",
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
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Password changed successfully"
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example="John Doe"
     *                     ),
     *                     @OA\Property(
     *                         property="email",
     *                         type="string",
     *                         example="QHs4o@example.com"
     *                     ),
     *                     @OA\Property(
     *                         property="display_name",
     *                         type="string",
     *                         example="John Doe"
     *                     ),
     *                     @OA\Property(
     *                         property="gender",
     *                         type="integer",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="active",
     *                         type="integer",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="role",
     *                         type="integer",
     *                         example=0
     *                     ),
     *                 ),
     *             ),
     *             @OA\Property(
     *                     property="error",
     *                     type="object",
     *                     example=null
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
     *                 example=null,
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Invalid data"
     *                 ),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="401",
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
     *                 example=null,
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Unauthorized"
     *                 ),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not Found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status_code",
     *                 type="integer",
     *                 example=404
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 example=null,
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="User not found"
     *                 ),
     *             ),
     *         ),
     *     ),
     * )
     */
    public function changePassword()
    {
    }


  /**
   * @OA\Patch(
   *     path="/api/v1/user/profile",
   *     operationId="updateProfile",
   *     summary="Update the authenticated user's profile information",
   *     description="Update the authenticated user's profile information",
   *     tags={"User"},
   *     security={{"bearerAuth": {}}},
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             type="object",
   *             @OA\Property(
   *                 property="name",
   *                 type="string",
   *                 example="John Doe"
   *             ),
   *             @OA\Property(
   *                 property="email",
   *                 type="string",
   *                 example="QHs4o@example.com"
   *             ),
   *             @OA\Property(
   *                 property="display_name",
   *                 type="string",
   *                 example="John Doe"
   *             ),
   *             @OA\Property(
   *                 property="gender",
   *                 type="integer",
   *                 example=1
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
   *                 @OA\Property(
   *                     property="message",
   *                     type="string",
   *                     example="Profile updated successfully"
   *                 ),
   *                 @OA\Property(
   *                     property="data",
   *                     type="object",
   *                     @OA\Property(
   *                         property="id",
   *                         type="integer",
   *                         example=1
   *                     ),
   *                     @OA\Property(
   *                         property="name",
   *                         type="string",
   *                         example="John Doe"
   *                     ),
   *                     @OA\Property(
   *                         property="email",
   *                         type="string",
   *                         example="QHs4o@example.com"
   *                     ),
   *                     @OA\Property(
   *                         property="display_name",
   *                         type="string",
   *                         example="John Doe"
   *                     ),
   *                     @OA\Property(
   *                         property="gender",
   *                         type="integer",
   *                         example=1
   *                     ),
   *                     @OA\Property(
   *                         property="active",
   *                         type="integer",
   *                         example=1
   *                     ),
   *                     @OA\Property(
   *                         property="role",
   *                         type="integer",
   *                         example=0
   *                     ),
   *                 ),
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
   *                 example=null,
   *             ),
   *             @OA\Property(
   *                 property="error",
   *                 type="object",
   *                 @OA\Property(
   *                     property="message",
   *                     type="string",
   *                     example="Invalid data"
   *                 ),
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
   *                 example=null,
   *             ),
   *             @OA\Property(
   *                 property="error",
   *                 type="object",
   *                 @OA\Property(
   *                     property="message",
   *                     type="string",
   *                     example="Unauthorized"
   *                 ),
   *             ),
   *         ),
   *     ),
   *     @OA\Response(
   *         response=404,
   *         description="Not Found",
   *         @OA\JsonContent(
   *             @OA\Property(
   *                 property="status_code",
   *                 type="integer",
   *                 example=404
   *             ),
   *             @OA\Property(
   *                 property="data",
   *                 type="object",
   *                 example=null,
   *             ),
   *             @OA\Property(
   *                 property="error",
   *                 type="object",
   *                 @OA\Property(
   *                     property="message",
   *                     type="string",
   *                     example="User not found"
   *                 ),
   *             ),
   *         ),
   *     ),
   * )
   */
    public function updateProfile()
    {
    }
}
