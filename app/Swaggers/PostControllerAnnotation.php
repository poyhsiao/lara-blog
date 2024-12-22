<?php

namespace App\Swaggers;

use OpenApi\Annotations as OA;

class PostControllerAnnotation extends ControllerAnnotation
{
    /**
     * @OA\Post(
     *     path="/api/v1/post",
     *     operationId="PostCreate",
     *     tags={"Post"},
     *     summary="Create a new post",
     *     description="Create a new post",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="title",
     *                 type="string",
     *                 example="the title",
     *             ),
     *             @OA\Property(
     *                 property="slug",
     *                 type="string",
     *                 example="the-slug",
     *             ),
     *             @OA\Property(
     *                 property="content",
     *                 type="string",
     *                 example="the content",
     *             ),
     *             @OA\Property(
     *                 property="publish_status",
     *                 type="integer",
     *                 example=1,
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
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
     *                     property="title",
     *                     type="string",
     *                     example="the title",
     *                 ),
     *                 @OA\Property(
     *                     property="slug",
     *                     type="string",
     *                     example="the-slug",
     *                 ),
     *                 @OA\Property(
     *                     property="content",
     *                     type="string",
     *                     example="the content",
     *                 ),
     *                 @OA\Property(
     *                     property="publish_status",
     *                     type="integer",
     *                     example=1,
     *                 ),
     *                 @OA\Property(
     *                     property="author",
     *                     type="integer",
     *                     example=1,
     *                 ),
     *                 @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     example="2020-01-01 00:00:00",
     *                 ),
     *                 @OA\Property(
     *                     property="updated_at",
     *                     type="string",
     *                     example="2020-01-01 00:00:00",
     *                 ),
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
     *                     example="Post not found"
     *                 ),
     *             ),
     *         ),
     *     ),
     * )
     */
    public function create()
    {
    }

    /**
     * @OA\Get(
     *     path="/api/v1/post/id/{id}",
     *     operationId="getPostById",
     *     tags={"Post"},
     *     summary="Get a post by ID",
     *     description="Get a post by ID",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example="1"
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
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
     *                     property="title",
     *                     type="string",
     *                     example="the title",
     *                 ),
     *                 @OA\Property(
     *                     property="slug",
     *                     type="string",
     *                     example="the-slug",
     *                 ),
     *                 @OA\Property(
     *                     property="content",
     *                     type="string",
     *                     example="the content",
     *                 ),
     *                 @OA\Property(
     *                     property="publish_status",
     *                     type="string",
     *                     example="published",
     *                 ),
     *                 @OA\Property(
     *                     property="author",
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
     *                         example="x5Oo2@example.com",
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
     *                         example=1,
     *                     ),
     *                 ),
     *                 @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     example="2020-01-01 00:00:00",
     *                 ),
     *                 @OA\Property(
     *                     property="updated_at",
     *                     type="string",
     *                     example="2020-01-01 00:00:00",
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
     *                     example="Post not found"
     *                 ),
     *             ),
     *         ),
     *     ),
     * )
     */
    public function getPostById()
    {
    }

    /**
     * @OA\Patch(
     *     path="/api/v1/post/{id}",
     *     operationId="PostUpdate",
     *     tags={"Post"},
     *     summary="Update a post",
     *     description="Update a post",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         ),
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="title",
     *                 type="string",
     *                 example="New title",
     *             ),
     *             @OA\Property(
     *                 property="slug",
     *                 type="string",
     *                 example="new-slug",
     *             ),
     *             @OA\Property(
     *                 property="content",
     *                 type="string",
     *                 example="New content",
     *             ),
     *             @OA\Property(
     *                 property="publish_status",
     *                 type="integer",
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
     *                     property="title",
     *                     type="string",
     *                     example="New title"
     *                 ),
     *                 @OA\Property(
     *                     property="slug",
     *                     type="string",
     *                     example="new-slug"
     *                 ),
     *                 @OA\Property(
     *                     property="content",
     *                     type="string",
     *                     example="New content"
     *                 ),
     *                 @OA\Property(
     *                     property="publish_status",
     *                     type="string",
     *                     example="published"
     *                 ),
     *                 @OA\Property(
     *                     property="author",
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
     *                         example="n2o3F@example.com"
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
     *                         example=1
     *                     ),
     *                 ),
     *                 @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     example="2022-01-01 00:00:00"
     *                 ),
     *                 @OA\Property(
     *                     property="updated_at",
     *                     type="string",
     *                     example="2022-01-01 00:00:00"
     *                 ),
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="object",
     *                 example=null,
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
     *                     example="Post not found"
     *                 ),
     *             ),
     *         ),
     *     ),
     *  )
     */
    public function update()
    {
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/delete",
     *     operationId="PostDelete",
     *     tags={"Post"},
     *     summary="Delete a new post",
     *     description="Delete a new post",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="title",
     *                 type="string",
     *                 example="the title",
     *             ),
     *             @OA\Property(
     *                 property="slug",
     *                 type="string",
     *                 example="the-slug",
     *             ),
     *             @OA\Property(
     *                 property="content",
     *                 type="string",
     *                 example="the content",
     *             ),
     *             @OA\Property(
     *                 property="publish_status",
     *                 type="integer",
     *                 example=1,
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
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
     *                     property="title",
     *                     type="string",
     *                     example="the title",
     *                 ),
     *                 @OA\Property(
     *                     property="slug",
     *                     type="string",
     *                     example="the-slug",
     *                 ),
     *                 @OA\Property(
     *                     property="content",
     *                     type="string",
     *                     example="the content",
     *                 ),
     *                 @OA\Property(
     *                     property="publish_status",
     *                     type="integer",
     *                     example=1,
     *                 ),
     *                 @OA\Property(
     *                     property="author",
     *                     type="integer",
     *                     example=1,
     *                 ),
     *                 @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     example="2020-01-01 00:00:00",
     *                 ),
     *                 @OA\Property(
     *                     property="updated_at",
     *                     type="string",
     *                     example="2020-01-01 00:00:00",
     *                 ),
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
     *                     example="Post not found"
     *                 ),
     *             ),
     *         ),
     *     ),
     * )
     */
    public function delete()
    {
    }

    /**
     * @OA\Get(
     *     path="/api/v1/posts",
     *     operationId="getPosts",
     *     summary="Get all posts",
     *     description="Get all posts",
     *     tags={"Post"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status_code",
     *                 type="integer",
     *                 example=200
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         example=1,
     *                     ),
     *                     @OA\Property(
     *                         property="slug",
     *                         type="string",
     *                         example="the-slug",
     *                     ),
     *                     @OA\Property(
     *                         property="title",
     *                         type="string",
     *                         example="the title",
     *                     ),
     *                     @OA\Property(
     *                         property="content",
     *                         type="string",
     *                         example="the content",
     *                     ),
     *                     @OA\Property(
     *                         property="publish_status",
     *                         type="integer",
     *                         example=1,
     *                     ),
     *                     @OA\Property(
     *                         property="user_id",
     *                         type="integer",
     *                         example=1,
     *                     ),
     *                     @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         example="2020-01-01 00:00:00",
     *                     ),
     *                     @OA\Property(
     *                         property="updated_at",
     *                         type="string",
     *                         example="2020-01-01 00:00:00",
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
     *                     example="Post not found"
     *                 ),
     *             ),
     *         ),
     *     ),
     * )
     */
    public function index() {}

    /**
     * @OA\Get(
     *     path="/api/v1/posts/trashed",
     *     operationId="getTrashedPosts",
     *     summary="Get trashed posts",
     *     description="Get trashed posts",
     *     tags={"Admin/Post"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status_code",
     *                 type="integer",
     *                 example=200,
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         example=1,
     *                     ),
     *                     @OA\Property(
     *                         property="title",
     *                         type="string",
     *                         example="the title",
     *                     ),
     *                     @OA\Property(
     *                         property="slug",
     *                         type="string",
     *                         example="the-slug",
     *                     ),
     *                     @OA\Property(
     *                         property="content",
     *                         type="string",
     *                         example="the content",
     *                     ),
     *                     @OA\Property(
     *                         property="publish_status",
     *                         type="integer",
     *                         example=1,
     *                     ),
     *                     @OA\Property(
     *                         property="user_id",
     *                         type="integer",
     *                         example=1,
     *                     ),
     *                     @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         example="2020-01-01 00:00:00",
     *                     ),
     *                     @OA\Property(
     *                         property="updated_at",
     *                         type="string",
     *                         example="2020-01-01 00:00:00",
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
     *                     example="Post not found"
     *                 ),
     *             ),
     *         ),
     *     ),
     * )
     */
    public function trashed()
    {
    }

    /**
     * @OA\Patch(
     *     path="/api/v1/post/restore/{id}",
     *     operationId="restorePost",
     *     tags={"Admin/Post"},
     *     summary="Restore a post",
     *     description="Restore a post",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Post id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
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
     *                     property="title",
     *                     type="string",
     *                     example="the title",
     *                 ),
     *                 @OA\Property(
     *                     property="slug",
     *                     type="string",
     *                     example="the-slug",
     *                 ),
     *                 @OA\Property(
     *                     property="content",
     *                     type="string",
     *                     example="the content",
     *                 ),
     *                 @OA\Property(
     *                     property="publish_status",
     *                     type="integer",
     *                     example=1,
     *                 ),
     *                 @OA\Property(
     *                     property="user_id",
     *                     type="integer",
     *                     example=1,
     *                 ),
     *                 @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     example="2020-01-01 00:00:00",
     *                 ),
     *                 @OA\Property(
     *                     property="updated_at",
     *                     type="string",
     *                     example="2020-01-01 00:00:00",
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
     *                     example="Post not found"
     *                 ),
     *             ),
     *         ),
     *     ),
     *  )
     */
    public function restore()
    {
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/post/force/{id}",
     *     operationId="forceDeletePost",
     *     tags={"Admin/Post"},
     *     summary="Force delete a post",
     *     description="Force delete a post",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Post id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
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
     *                     property="title",
     *                     type="string",
     *                     example="the title",
     *                 ),
     *                 @OA\Property(
     *                     property="slug",
     *                     type="string",
     *                     example="the-slug",
     *                 ),
     *                 @OA\Property(
     *                     property="content",
     *                     type="string",
     *                     example="the content",
     *                 ),
     *                 @OA\Property(
     *                     property="publish_status",
     *                     type="integer",
     *                     example=1,
     *                 ),
     *                 @OA\Property(
     *                     property="user_id",
     *                     type="integer",
     *                     example=1,
     *                 ),
     *                 @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     example="2020-01-01 00:00:00",
     *                 ),
     *                 @OA\Property(
     *                     property="updated_at",
     *                     type="string",
     *                     example="2020-01-01 00:00:00",
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
     *                     example="Post not found"
     *                 ),
     *             ),
     *         ),
     *     ),
     *  )
     */
    public function forceDelete()
    {
    }
}
