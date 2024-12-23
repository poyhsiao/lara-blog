<?php

namespace App\Swaggers;

use OpenApi\Annotations as OA;

class TagControllerAnnotation extends ControllerAnnotation
{
    /**
     * @OA\Get(
     *     path="/api/v1/tag",
     *     summary="Get all tags",
     *     tags={"Tag"},
     *     operationId="TagIndex",
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
     *                     example="Tag 1",
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                     example="Description 1",
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
    public function index() {}

    /**
     * @OA\Get(
     *     path="/api/v1/tag/id/{id}",
     *     operationId="getTagById",
     *     tags={"Tag"},
     *     summary="Get a tag by ID",
     *     description="Get a tag by ID",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
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
     *                     property="name",
     *                     type="string",
     *                     example="Tag 1",
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                     example="Description 1",
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
    public function getById() {}

    /**
     * @OA\Get(
     *     path="/api/v1/tag/trashed",
     *     operationId="getTrashedTags",
     *     tags={"Tag"},
     *     summary="Get trashed tags",
     *     description="Get trashed tags",
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
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     example=1,
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="Tag 1",
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                     example="Description 1",
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
    public function trashed()
    {
    }

    /**
     * @OA\Post(
     *     path="/api/v1/tag",
     *     operationId="TagCreate",
     *     tags={"Tag"},
     *     summary="Create a new tag",
     *     description="Create a new tag",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name"},
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 example="Tag 1",
     *             ),
     *             @OA\Property(
     *                 property="description",
     *                 type="string",
     *                 example="Description 1",
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
     *                     property="name",
     *                     type="string",
     *                     example="Tag 1",
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                     example="Description 1",
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
    public function create() {}

    /**
     * @OA\Patch(
     *     path="/api/v1/tag/id/{id}",
     *     operationId="TagUpdate",
     *     tags={"Admin/Tag"},
     *     summary="Update a tag",
     *     description="Update a tag",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1,
     *         ),
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 example="Tag 1",
     *             ),
     *             @OA\Property(
     *                 property="description",
     *                 type="string",
     *                 example="Description 1",
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
     *                     property="name",
     *                     type="string",
     *                     example="Tag 1",
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                     example="Description 1",
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
    public function update() {}

    /**
     * @OA\Delete(
     *     path="/api/v1/tag/id/{id}",
     *     operationId="TagDelete",
     *     tags={"Admin/Tag"},
     *     summary="Delete a tag",
     *     description="Delete a tag",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
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
     *                     property="name",
     *                     type="string",
     *                     example="Tag 1",
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                     example="Description 1",
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
    public function delete() {}

    /**
     * @OA\Patch(
     *     path="/api/v1/tag/restore/{id}",
     *     operationId="TagRestore",
     *     tags={"Admin/Tag"},
     *     summary="Restore a tag",
     *     description="Restore a tag",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
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
     *                     property="name",
     *                     type="string",
     *                     example="Tag 1",
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                     example="Description 1",
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
    public function restore() {}

    /**
     * @OA\Delete(
     *     path="/api/v1/tag/force-delete/{id}",
     *     operationId="TagForceDelete",
     *     tags={"Admin/Tag"},
     *     summary="Force delete a tag",
     *     description="Force delete a tag",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
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
     *                     property="name",
     *                     type="string",
     *                     example="Tag 1",
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                     example="Description 1",
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
    public function forceDelete() {}
}
