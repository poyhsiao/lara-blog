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

    /**
     * @OA\Get(
     *     path="/api/v1/user/posts",
     *     operationId="userPosts",
     *     tags={"User"},
     *     summary="Get posts of the authenticated user",
     *     description="Get posts of the authenticated user",
     *     security={{"bearerAuth": {}}},
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
     *                 property="message",
     *                 type="string",
     *                 example="Get all posts successfully",
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
     *                     example="QHs4o@example.com",
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
     *                     example=0,
     *                 ),
     *                 @OA\Property(
     *                     property="posts",
     *                     type="array",
     *                     @OA\Items(
     *                         @OA\Property(
     *                             type="object",
     *                             @OA\Property(
     *                                 property="id",
     *                                 type="integer",
     *                                 example=1,
     *                             ),
     *                             @OA\Property(
     *                                 property="title",
     *                                 type="string",
     *                                 example="Post title",
     *                             ),
     *                             @OA\Property(
     *                                 property="slug",
     *                                 type="string",
     *                                 example="post-title",
     *                             ),
     *                             @OA\Property(
     *                                 property="content",
     *                                 type="string",
     *                                 example="Post content",
     *                             ),
     *                             @OA\Property(
     *                                 property="publish_status",
     *                                 type="string",
     *                                 example="published",
     *                             ),
     *                             @OA\Property(
     *                                 property="author",
     *                                 type="integer",
     *                                 example=1,
     *                             ),
     *                             @OA\Property(
     *                                 property="created_at",
     *                                 type="string",
     *                                 example="2021-01-01 00:00:00",
     *                             ),
     *                             @OA\Property(
     *                                 property="updated_at",
     *                                 type="string",
     *                                 example="2021-01-01 00:00:00",
     *                             ),
     *                         ),
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
    public function getPosts()
    {
    }

    /**
     * @OA\Get(
     *     path="/api/v1/user/id/{id}",
     *     operationId="getUserById",
     *     tags={"Admin/User"},
     *     summary="Get a user by ID",
     *     description="Get a user by ID",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="posts",
     *                 type="integer",
     *                 enum={1, 0},
     *                 description="Include posts, 0 = no, 1 = yes",
     *                 default=0,
     *                 example=1,
     *             ),
     *             @OA\Property(
     *                 property="comments",
     *                 type="integer",
     *                 enum={1, 0},
     *                 description="Include comments, 0 = no, 1 = yes",
     *                 default=0,
     *                 example=1,
     *             ),
     *             @OA\Property(
     *                 property="emotions",
     *                 type="integer",
     *                 enum={1, 0},
     *                 description="Include emotions, 0 = no, 1 = yes",
     *                 default=0,
     *                 example=1,
     *             ),
     *             @OA\Property(
     *                 property="emotionUsers",
     *                 type="integer",
     *                 enum={1, 0},
     *                 description="Include emotion users, 0 = no, 1 = yes",
     *                 default=0,
     *                 example=1,
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
     *                     example="QHs4o@example.com",
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
     *                 @OA\Property(
     *                     property="posts",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(
     *                             property="id",
     *                             type="integer",
     *                             example=1,
     *                         ),
     *                         @OA\Property(
     *                             property="title",
     *                             type="string",
     *                             example="My first post",
     *                         ),
     *                         @OA\Property(
     *                             property="slug",
     *                             type="string",
     *                             example="my-first-post",
     *                         ),
     *                         @OA\Property(
     *                             property="content",
     *                             type="string",
     *                             example="This is my first post",
     *                         ),
     *                         @OA\Property(
     *                             property="user_id",
     *                             type="integer",
     *                             example=1,
     *                         ),
     *                         @OA\Property(
     *                             property="created_at",
     *                             type="string",
     *                             example="2021-01-01 00:00:00",
     *                         ),
     *                         @OA\Property(
     *                             property="updated_at",
     *                             type="string",
     *                             example="2021-01-01 00:00:00",
     *                         ),
     *                     ),
     *                 ),
     *                 @OA\Property(
     *                     property="comments",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(
     *                             property="id",
     *                             type="integer",
     *                             example=1,
     *                         ),
     *                         @OA\Property(
     *                             property="content",
     *                             type="string",
     *                             example="This is my first comment",
     *                         ),
     *                         @OA\Property(
     *                             property="replyable",
     *                             type="integer",
     *                             example=1,
     *                         ),
     *                         @OA\Property(
     *                             property="created_at",
     *                             type="string",
     *                             example="2021-01-01 00:00:00",
     *                         ),
     *                         @OA\Property(
     *                             property="updated_at",
     *                             type="string",
     *                             example="2021-01-01 00:00:00",
     *                         ),
     *                     ),
     *                 ),
     *                 @OA\Property(
     *                     property="emotions",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(
     *                             property="id",
     *                             type="integer",
     *                             example=1,
     *                         ),
     *                         @OA\Property(
     *                             property="name",
     *                             type="string",
     *                             example="like",
     *                         ),
     *                         @OA\Property(
     *                             property="description",
     *                             type="string",
     *                             example="Like",
     *                         ),
     *                         @OA\Property(
     *                             property="avatar",
     *                             type="string",
     *                             example="http://www.example.com/avatar.jpg",
     *                         ),
     *                     ),
     *                 ),
     *                 @OA\Property(
     *                     property="emotions_users",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(
     *                             property="id",
     *                             type="integer",
     *                             example=1,
     *                         ),
     *                         @OA\Property(
     *                             property="user_id",
     *                             type="integer",
     *                             example=1,
     *                         ),
     *                         @OA\Property(
     *                             property="emotionable_id",
     *                             type="integer",
     *                             example=1,
     *                         ),
     *                         @OA\Property(
     *                             property="emotionable_type",
     *                             type="string",
     *                             example="posts",
     *                         ),
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
    public function getById()
    {
    }

    /**
     * @OA\Get(
     *     path="/api/v1/user/comments",
     *     operationId="userGetComments",
     *     tags={"User"},
     *     summary="Get comments of the authenticated user",
     *     description="Get comments of the authenticated user",
     *     security={{"bearerAuth": {}}},
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
     *                     example="QHs4o@example.com",
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
     *                 @OA\Property(
     *                     property="comments",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(
     *                             property="id",
     *                             type="integer",
     *                             example=1,
     *                         ),
     *                         @OA\Property(
     *                             property="content",
     *                             type="string",
     *                             example="This is a comment",
     *                         ),
     *                         @OA\Property(
     *                             property="replyable",
     *                             type="integer",
     *                             example=1,
     *                         ),
     *                         @OA\Property(
     *                             property="created_at",
     *                             type="string",
     *                             example="2021-01-01 00:00:00",
     *                         ),
     *                         @OA\Property(
     *                             property="updated_at",
     *                             type="string",
     *                             example="2021-01-01 00:00:00",
     *                         ),
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
    public function getComments()
    {
    }

    /**
     * @OA\Get(
     *     path="/api/v1/user/emotions",
     *     operationId="userGetEmotions",
     *     tags={"User"},
     *     summary="Get emotions of the authenticated user",
     *     description="Get emotions of the authenticated user",
     *     security={{"bearerAuth": {}}},
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
     *                     example="QHs4o@example.com",
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
     *                     example=0,
     *                 ),
     *                 @OA\Property(
     *                     property="emotions",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(
     *                             property="id",
     *                             type="integer",
     *                             example=1,
     *                         ),
     *                         @OA\Property(
     *                             property="name",
     *                             type="string",
     *                             example="Like",
     *                         ),
     *                         @OA\Property(
     *                             property="description",
     *                             type="string",
     *                             example="Like",
     *                         ),
     *                         @OA\Property(
     *                             property="avatar",
     *                             type="string",
     *                             example="http://www.example.com/avatar.jpg",
     *                         ),
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
    public function getEmotions()
    {
    }

    /**
     * @OA\Get(
     *     path="/api/v1/user/emotions/me",
     *     operationId="userGetEmotionsToMe",
     *     tags={"User"},
     *     summary="Get emotions to me",
     *     description="Get emotions to me",
     *     security={{"bearerAuth": {}}},
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
     *                     example="QHs4o@example.com",
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
     *                 @OA\Property(
     *                     property="emotion_users",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(
     *                             property="id",
     *                             type="integer",
     *                             example=1,
     *                         ),
     *                         @OA\Property(
     *                             property="user_id",
     *                             type="integer",
     *                             example=1,
     *                         ),
     *                         @OA\Property(
     *                             property="emotion_id",
     *                             type="integer",
     *                             example=1,
     *                         ),
     *                         @OA\Property(
     *                             property="emotionable_type",
     *                             type="string",
     *                             example="posts",
     *                         ),
     *                         @OA\Property(
     *                             property="emotionable_id",
     *                             type="integer",
     *                             example=1,
     *                         ),
     *                         @OA\Property(
     *                             property="created_at",
     *                             type="string",
     *                             example="2021-01-01 00:00:00",
     *                         ),
     *                         @OA\Property(
     *                             property="updated_at",
     *                             type="string",
     *                             example="2021-01-01 00:00:00",
     *                         ),
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
    public function getEmotionsToMe() {}
}
