<?php

namespace App\Swaggers;

use OpenApi\Annotations as OA;

class CommentControllerAnnotation extends ControllerAnnotation
{
    /**
     * @OA\Get(
     *     path="/api/v1/comment",
     *     operationId="commentIndex",
     *     tags={"Comment"},
     *     summary="Get all comments",
     *     description="Get all comments",
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
     *                         type="object",
     *                         @OA\Property(
     *                             property="id",
     *                             type="integer",
     *                             example=1,
     *                         ),
     *                         @OA\Property(
     *                             property="content",
     *                             type="string",
     *                             example="Comment 1",
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
     *                    ),
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
    public function index()
    {
    }

    /**
     * @OA\Get(
     *     path="/api/v1/comment/id/{id}",
     *     operationId="commentGetById",
     *     tags={"Comment"},
     *     summary="Get a comment by ID",
     *     description="Get a comment by ID",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the comment to retrieve",
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status_code",
     *                 type="integer",
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
     *                     property="content",
     *                     type="string",
     *                     example="Comment 1",
     *                 ),
     *                 @OA\Property(
     *                     property="replyable",
     *                     type="integer",
     *                     example=1,
     *                 ),
     *                 @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     example="2021-01-01 00:00:00",
     *                 ),
     *                 @OA\Property(
     *                     property="updated_at",
     *                     type="string",
     *                     example="2021-01-01 00:00:00",
     *                 ),
     *            ),
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
    public function getById()
    {
    }

    /**
     * @OA\Post(
     *     path="/api/v1/comment",
     *     operationId="commentCreate",
     *     tags={"Comment"},
     *     summary="Create a new comment",
     *     description="Create a new comment",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"content", "replyable"},
     *             @OA\Property(
     *                 property="content",
     *                 type="string",
     *                 example="Comment 1",
     *             ),
     *             @OA\Property(
     *                 property="replyable",
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
     *                     property="content",
     *                     type="string",
     *                     example="Comment 1",
     *                 ),
     *                 @OA\Property(
     *                     property="replyable",
     *                     type="integer",
     *                     example=1,
     *                 ),
     *                 @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     example="2021-01-01 00:00:00",
     *                 ),
     *                 @OA\Property(
     *                     property="updated_at",
     *                     type="string",
     *                     example="2021-01-01 00:00:00",
     *                 ),
     *            ),
     *            @OA\Property(
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
    public function create()
    {
    }

    /**
     * @OA\Patch(
     *     path="/api/v1/comment/id/{id}",
     *     operationId="commentUpdate",
     *     tags={"Comment"},
     *     summary="Update a comment",
     *     description="Update a comment",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Comment id",
     *         required=true,
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="content",
     *                 type="string",
     *                 example="Comment 1",
     *             ),
     *             @OA\Property(
     *                 property="replyable",
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
     *                     property="id",
     *                     type="integer",
     *                     example=1,
     *                 ),
     *                 @OA\Property(
     *                     property="content",
     *                     type="string",
     *                     example="Comment 1",
     *                 ),
     *                 @OA\Property(
     *                     property="replyable",
     *                     type="integer",
     *                     example=1,
     *                 ),
     *                 @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     example="2021-01-01 00:00:00",
     *                 ),
     *                 @OA\Property(
     *                     property="updated_at",
     *                     type="string",
     *                     example="2021-01-01 00:00:00",
     *                 ),
     *            ),
     *            @OA\Property(
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
    public function update()
    {}

    /**
     * @OA\Delete(
     *     path="/api/v1/comment/id/{id}",
     *     summary="Delete a comment",
     *     operationId="commentDelete",
     *     tags={"Comment"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Comment id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int",
     *             example=1,
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
     *                     property="content",
     *                     type="string",
     *                     example="Comment 1",
     *                 ),
     *                 @OA\Property(
     *                     property="replyable",
     *                     type="integer",
     *                     example=1,
     *                 ),
     *                 @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     example="2021-01-01 00:00:00",
     *                 ),
     *                 @OA\Property(
     *                     property="updated_at",
     *                     type="string",
     *                     example="2021-01-01 00:00:00",
     *                 ),
     *            ),
     *            @OA\Property(
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
    public function delete()
    {}

    /**
     * @OA\Patch(
     *     path="/api/v1/comment/restore/{id}",
     *     operationId="commentRestore",
     *     tags={"Comment"},
     *     summary="Restore a comment",
     *     description="Restore a comment",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Comment id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int",
     *             example=1,
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
     *                     property="content",
     *                     type="string",
     *                     example="Comment 1",
     *                 ),
     *                 @OA\Property(
     *                     property="replyable",
     *                     type="string",
     *                     example=1,
     *                 ),
     *                 @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     example="2021-01-01 00:00:00",
     *                 ),
     *                 @OA\Property(
     *                     property="updated_at",
     *                     type="string",
     *                     example="2021-01-01 00:00:00",
     *                 ),
     *            ),
     *            @OA\Property(
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
    public function restore()
    {}
}
