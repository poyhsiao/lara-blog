<?php

namespace App\Swaggers;

use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class AdminControllerAnnotation extends ControllerAnnotation
{
    /**
     * @OA\Get(
     *     path="/api/admin/user/detail",
     *     operationId="getUserDetail",
     *     summary="Get user detail by email, name, or id",
     *     description="Get user detail by email, name, or id",
     *     tags={"Admin/User"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="user",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             description="Name, email, or ID",
     *             example="QHs4o@example.com"
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
     *                     property="message",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="object",
     *                     @OA\Property(
     *                         property="user",
     *                         type="array",
     *                         @OA\Items(
     *                           @OA\Property(
     *                               property="id",
     *                               type="integer",
     *                               example=1
     *                           ),
     *                           @OA\Property(
     *                               property="name",
     *                               type="string",
     *                               example="John Doe"
     *                           ),
     *                           @OA\Property(
     *                               property="email",
     *                               type="string",
     *                               example="QHs4o@example.com"
     *                           ),
     *                           @OA\Property(
     *                               property="display_name",
     *                               type="string",
     *                               example="John Doe"
     *                           ),
     *                           @OA\Property(
     *                               property="email_verified_at",
     *                               type="string",
     *                               example="2020-01-01 00:00:00"
     *                           ),
     *                           @OA\Property(
     *                               property="gender",
     *                               type="integer",
     *                               example=1
     *                           ),
     *                           @OA\Property(
     *                               property="active",
     *                               type="integer",
     *                               example=1
     *                           ),
     *                           @OA\Property(
     *                               property="role",
     *                               type="integer",
     *                               example=1
     *                           ),
     *                           @OA\Property(
     *                               property="created_at",
     *                               type="string",
     *                               example="2020-01-01 00:00:00"
     *                           ),
     *                           @OA\Property(
     *                               property="updated_at",
     *                               type="string",
     *                               example="2020-01-01 00:00:00"
     *                           ),
     *                           @OA\Property(
     *                               property="deleted_at",
     *                               type="string",
     *                               example="2020-01-01 00:00:00"
     *                           ),
     *                        ),
     *                     ),
     *                 ),
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
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
    public function getUserDetail(Request $request)
    {
    }

    /**
     * @OA\Get(
     *     path="/api/admin/user/all",
     *     operationId="getAllUsers",
     *     tags={"Admin/User"},
     *     summary="Get all users data (paginated)",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number, default: 1",
     *         required=false,
     *         example="1",
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Number of items per page, default: 10",
     *         required=false,
     *         example="10",
     *     ),
     *     @OA\Parameter(
     *         name="order",
     *         in="query",
     *         description="Order by field, default: id",
     *         required=false,
     *         example="id",
     *     ),
     *     @OA\Parameter(
     *         name="detail",
     *         in="query",
     *         description="Show user detail, 0 = no, 1 = yes, default: 0",
     *         required=false,
     *         example="0",
     *     ),
     *     @OA\Parameter(
     *         name="desc",
     *         in="query",
     *         description="Order by desc, 0 = asc, 1 = desc, default: 0",
     *         required=false,
     *         example="0",
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
     *                     property="message",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="object",
     *                     @OA\Property(
     *                         property="users",
     *                         type="object",
     *                         @OA\Property(
     *                             property="meta",
     *                             type="object",
     *                             @OA\Property(
     *                                 property="current_page",
     *                                 type="integer",
     *                                 example=1
     *                             ),
     *                             @OA\Property(
     *                                 property="total",
     *                                 type="integer",
     *                                 example=100
     *                             ),
     *                             @OA\Property(
     *                                 property="items_per_page",
     *                                 type="integer",
     *                                 example=10
     *                             ),
     *                             @OA\Property(
     *                                 property="last_page",
     *                                 type="integer",
     *                                 example=10
     *                             ),
     *                             @OA\Property(
     *                                 property="next_page_url",
     *                                 type="string",
     *                                 example="http://localhost:8000/api/ admin/users/all?page=2"
     *                             ),
     *                             @OA\Property(
     *                                 property="prev_page_url",
     *                                 type="string",
     *                                 example="http://localhost:8000/api/ admin/users/all?page=1"
     *                             ),
     *                             @OA\Property(
     *                                 property="last_page_url",
     *                                 type="string",
     *                                 example="http://localhost:8000/api/ admin/users/all?page=10"
     *                             ),
     *                             @OA\Property(
     *                                 property="options",
     *                                 type="object",
     *                                 @OA\Property(
     *                                     property="path",
     *                                     type="string",
     *                                     example="http://localhost:8000/ api/admin/users/all"
     *                                 ),
     *                                 @OA\Property(
     *                                     property="pageName",
     *                                     type="string",
     *                                     example="users"
     *                                 ),
     *                             ),
     *                         ),
     *                         @OA\Property(
     *                             property="users",
     *                             type="array",
     *                             @OA\Items(
     *                                 @OA\Property(
     *                                     property="id",
     *                                     type="integer",
     *                                     example=1
     *                                 ),
     *                                 @OA\Property(
     *                                     property="name",
     *                                     type="string",
     *                                     example="John Doe"
     *                                 ),
     *                                 @OA\Property(
     *                                     property="email",
     *                                     type="string",
     *                                     example="QHs4o@example.com"
     *                                 ),
     *                                 @OA\Property(
     *                                     property="display_name",
     *                                     type="string",
     *                                     example="John Doe"
     *                                 ),
     *                                 @OA\Property(
     *                                     property="email_verified_at",
     *                                     type="string",
     *                                     example="2021-01-01 00:00:00"
     *                                 ),
     *                                 @OA\Property(
     *                                     property="gender",
     *                                     type="integer",
     *                                     example=1
     *                                 ),
     *                                 @OA\Property(
     *                                     property="active",
     *                                     type="integer",
     *                                     example=1
     *                                 ),
     *                                 @OA\Property(
     *                                     property="role",
     *                                     type="integer",
     *                                     example=1
     *                                 ),
     *                                 @OA\Property(
     *                                     property="created_at",
     *                                     type="string",
     *                                     example="2021-01-01 00:00:00"
     *                                 ),
     *                                 @OA\Property(
     *                                     property="updated_at",
     *                                     type="string",
     *                                     example="2021-01-01 00:00:00"
     *                                 ),
     *                                 @OA\Property(
     *                                     property="deleted_at",
     *                                     type="string",
     *                                     example="2021-01-01 00:00:00"
     *                                 ),
     *                             ),
     *                         ),
     *                     ),
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
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 example=null
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Invalid data"
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         @OA\Property(
     *                             property="page",
     *                             type="string",
     *                             example="page must be an integer"
     *                         ),
     *                         @OA\Property(
     *                             property="limit",
     *                             type="string",
     *                             example="limit must be an integer"
     *                         ),
     *                     ),
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
     *                 example=null
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Invalid token"
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="string",
     *                     example="The token could not be parsed from the request",
     *                 ),
     *             ),
     *         ),
     *     ),
     * )
     */
    public function getAllUsers(Request $request)
    {
    }

    /**
     * @OA\Get(
     *     path="/api/admin/user/inactive",
     *     operationId="getInactiveUser",
     *     tags={"Admin/User"},
     *     summary="Get all inactive users data (paginated)",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number, default: 1",
     *         required=false,
     *         example="1",
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Number of items per page, default: 10",
     *         required=false,
     *         example="10",
     *     ),
     *     @OA\Parameter(
     *         name="order",
     *         in="query",
     *         description="Order by field, default: id",
     *         required=false,
     *         example="id",
     *     ),
     *     @OA\Parameter(
     *         name="detail",
     *         in="query",
     *         description="Show user detail, 0 = no, 1 = yes, default: 0",
     *         required=false,
     *         example="0",
     *     ),
     *     @OA\Parameter(
     *         name="desc",
     *         in="query",
     *         description="Order by desc, 0 = asc, 1 = desc, default: 0",
     *         required=false,
     *         example="0",
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
     *                     property="message",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="object",
     *                     @OA\Property(
     *                         property="users",
     *                         type="object",
     *                         @OA\Property(
     *                             property="meta",
     *                             type="object",
     *                             @OA\Property(
     *                                 property="current_page",
     *                                 type="integer",
     *                                 example=1
     *                             ),
     *                             @OA\Property(
     *                                 property="total",
     *                                 type="integer",
     *                                 example=100
     *                             ),
     *                             @OA\Property(
     *                                 property="items_per_page",
     *                                 type="integer",
     *                                 example=10
     *                             ),
     *                             @OA\Property(
     *                                 property="last_page",
     *                                 type="integer",
     *                                 example=10
     *                             ),
     *                             @OA\Property(
     *                                 property="next_page_url",
     *                                 type="string",
     *                                 example="http://localhost:8000/api/admin/users/inactive?page=2"
     *                             ),
     *                             @OA\Property(
     *                                 property="prev_page_url",
     *                                 type="string",
     *                                 example="http://localhost:8000/api/admin/users/inactive?page=1"
     *                             ),
     *                             @OA\Property(
     *                                 property="last_page_url",
     *                                 type="string",
     *                                 example="http://localhost:8000/api/admin/users/inactive?page=10"
     *                             ),
     *                             @OA\Property(
     *                                 property="options",
     *                                 type="object",
     *                                 @OA\Property(
     *                                     property="path",
     *                                     type="string",
     *                                     example="http://localhost:8000/api/admin/users/inactive"
     *                                 ),
     *                                 @OA\Property(
     *                                     property="pageName",
     *                                     type="string",
     *                                     example="users"
     *                                 ),
     *                             ),
     *                         ),
     *                         @OA\Property(
     *                             property="users",
     *                             type="array",
     *                             @OA\Items(
     *                                 @OA\Property(
     *                                     property="id",
     *                                     type="integer",
     *                                     example=1
     *                                 ),
     *                                 @OA\Property(
     *                                     property="name",
     *                                     type="string",
     *                                     example="John Doe"
     *                                 ),
     *                                 @OA\Property(
     *                                     property="email",
     *                                     type="string",
     *                                     example="QHs4o@example.com"
     *                                 ),
     *                                 @OA\Property(
     *                                     property="display_name",
     *                                     type="string",
     *                                     example="John Doe"
     *                                 ),
     *                                 @OA\Property(
     *                                     property="email_verified_at",
     *                                     type="string",
     *                                     example="2021-01-01 00:00:00"
     *                                 ),
     *                                 @OA\Property(
     *                                     property="gender",
     *                                     type="integer",
     *                                     example=1
     *                                 ),
     *                                 @OA\Property(
     *                                     property="active",
     *                                     type="integer",
     *                                     example=1
     *                                 ),
     *                                 @OA\Property(
     *                                     property="role",
     *                                     type="integer",
     *                                     example=1
     *                                 ),
     *                                 @OA\Property(
     *                                     property="created_at",
     *                                     type="string",
     *                                     example="2021-01-01 00:00:00"
     *                                 ),
     *                                 @OA\Property(
     *                                     property="updated_at",
     *                                     type="string",
     *                                     example="2021-01-01 00:00:00"
     *                                 ),
     *                                 @OA\Property(
     *                                     property="deleted_at",
     *                                     type="string",
     *                                     example="2021-01-01 00:00:00"
     *                                 ),
     *                             ),
     *                         ),
     *                     ),
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
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 example=null
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Invalid data"
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         @OA\Property(
     *                             property="page",
     *                             type="string",
     *                             example="page must be an integer"
     *                         ),
     *                         @OA\Property(
     *                             property="limit",
     *                             type="string",
     *                             example="limit must be an integer"
     *                         ),
     *                     ),
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
     *                 example=null
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Invalid token"
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="string",
     *                     example="The token could not be parsed from the request",
     *                 ),
     *             ),
     *         ),
     *     ),
     * )
     */
    public function getInactiveUsers(Request $request)
    {
    }

    /**
     * @OA\Get(
     *     path="/api/admin/user/invalid",
     *     operationId="getInvalidUsers",
     *     tags={"Admin/User"},
     *     summary="Get all invalid users data (paginated)",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number, default: 1",
     *         required=false,
     *         example="1",
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Number of items per page, default: 10",
     *         required=false,
     *         example="10",
     *     ),
     *     @OA\Parameter(
     *         name="order",
     *         in="query",
     *         description="Order by field, default: id",
     *         required=false,
     *         example="id",
     *     ),
     *     @OA\Parameter(
     *         name="detail",
     *         in="query",
     *         description="Show user detail, 0 = no, 1 = yes, default: 0",
     *         required=false,
     *         example="0",
     *     ),
     *     @OA\Parameter(
     *         name="desc",
     *         in="query",
     *         description="Order by desc, 0 = asc, 1 = desc, default: 0",
     *         required=false,
     *         example="0",
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
     *                     property="message",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="object",
     *                     @OA\Property(
     *                         property="users",
     *                         type="object",
     *                         @OA\Property(
     *                             property="meta",
     *                             type="object",
     *                             @OA\Property(
     *                                 property="current_page",
     *                                 type="integer",
     *                                 example=1
     *                             ),
     *                             @OA\Property(
     *                                 property="total",
     *                                 type="integer",
     *                                 example=100
     *                             ),
     *                             @OA\Property(
     *                                 property="items_per_page",
     *                                 type="integer",
     *                                 example=10
     *                             ),
     *                             @OA\Property(
     *                                 property="last_page",
     *                                 type="integer",
     *                                 example=10
     *                             ),
     *                             @OA\Property(
     *                                 property="next_page_url",
     *                                 type="string",
     *                                 example="http://localhost:8000/api/admin/users/invalid?page=2"
     *                             ),
     *                             @OA\Property(
     *                                 property="prev_page_url",
     *                                 type="string",
     *                                 example="http://localhost:8000/api/admin/users/invalid?page=1"
     *                             ),
     *                             @OA\Property(
     *                                 property="last_page_url",
     *                                 type="string",
     *                                 example="http://localhost:8000/api/admin/users/invalid?page=10"
     *                             ),
     *                             @OA\Property(
     *                                 property="options",
     *                                 type="object",
     *                                 @OA\Property(
     *                                     property="path",
     *                                     type="string",
     *                                     example="http://localhost:8000/api/admin/users/invalid"
     *                                 ),
     *                                 @OA\Property(
     *                                     property="pageName",
     *                                     type="string",
     *                                     example="users"
     *                                 ),
     *                             ),
     *                         ),
     *                         @OA\Property(
     *                             property="users",
     *                             type="array",
     *                             @OA\Items(
     *                                 @OA\Property(
     *                                     property="id",
     *                                     type="integer",
     *                                     example=1
     *                                 ),
     *                                 @OA\Property(
     *                                     property="name",
     *                                     type="string",
     *                                     example="John Doe"
     *                                 ),
     *                                 @OA\Property(
     *                                     property="email",
     *                                     type="string",
     *                                     example="QHs4o@example.com"
     *                                 ),
     *                                 @OA\Property(
     *                                     property="display_name",
     *                                     type="string",
     *                                     example="John Doe"
     *                                 ),
     *                                 @OA\Property(
     *                                     property="email_verified_at",
     *                                     type="string",
     *                                     example="2021-01-01 00:00:00"
     *                                 ),
     *                                 @OA\Property(
     *                                     property="gender",
     *                                     type="integer",
     *                                     example=1
     *                                 ),
     *                                 @OA\Property(
     *                                     property="active",
     *                                     type="integer",
     *                                     example=1
     *                                 ),
     *                                 @OA\Property(
     *                                     property="role",
     *                                     type="integer",
     *                                     example=1
     *                                 ),
     *                                 @OA\Property(
     *                                     property="created_at",
     *                                     type="string",
     *                                     example="2021-01-01 00:00:00"
     *                                 ),
     *                                 @OA\Property(
     *                                     property="updated_at",
     *                                     type="string",
     *                                     example="2021-01-01 00:00:00"
     *                                 ),
     *                                 @OA\Property(
     *                                     property="deleted_at",
     *                                     type="string",
     *                                     example="2021-01-01 00:00:00"
     *                                 ),
     *                             ),
     *                         ),
     *                     ),
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
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 example=null
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Invalid data"
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         @OA\Property(
     *                             property="page",
     *                             type="string",
     *                             example="page must be an integer"
     *                         ),
     *                         @OA\Property(
     *                             property="limit",
     *                             type="string",
     *                             example="limit must be an integer"
     *                         ),
     *                     ),
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
     *                 example=null
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Invalid token"
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="string",
     *                     example="The token could not be parsed from the request",
     *                 ),
     *             ),
     *         ),
     *     ),
     * )
     */
    public function getNonValidatedUsers(Request $request)
    {
    }

    /**
     * @OA\Get(
     *     path="/api/admin/user/trashed",
     *     operationId="getAllTrashedUsers",
     *     tags={"Admin/User"},
     *     summary="Get all soft-deleted users data (paginated)",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number, default: 1",
     *         required=false,
     *         example="1",
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Number of items per page, default: 10",
     *         required=false,
     *         example="10",
     *     ),
     *     @OA\Parameter(
     *         name="order",
     *         in="query",
     *         description="Order by field, default: id",
     *         required=false,
     *         example="id",
     *     ),
     *     @OA\Parameter(
     *         name="detail",
     *         in="query",
     *         description="Show user detail, 0 = no, 1 = yes, default:  0",
     *         required=false,
     *         example="0",
     *     ),
     *     @OA\Parameter(
     *         name="desc",
     *         in="query",
     *         description="Order by desc, 0 = asc, 1 = desc, default: 0",
     *         required=false,
     *         example="0",
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
     *                     property="message",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="object",
     *                     @OA\Property(
     *                         property="users",
     *                         type="object",
     *                         @OA\Property(
     *                             property="meta",
     *                             type="object",
     *                             @OA\Property(
     *                                 property="current_page",
     *                                 type="integer",
     *                                 example=1
     *                             ),
     *                             @OA\Property(
     *                                 property="total",
     *                                 type="integer",
     *                                 example=100
     *                             ),
     *                             @OA\Property(
     *                                 property="items_per_page",
     *                                 type="integer",
     *                                 example=10
     *                             ),
     *                             @OA\Property(
     *                                 property="last_page",
     *                                 type="integer",
     *                                 example=10
     *                             ),
     *                             @OA\Property(
     *                                 property="next_page_url",
     *                                 type="string",
     *                                 example="http://localhost:8000/api/admin/users/trashed?page=2"
     *                             ),
     *                             @OA\Property(
     *                                 property="prev_page_url",
     *                                 type="string",
     *                                 example="http://localhost:8000/api/admin/users/trashed?page=1"
     *                             ),
     *                             @OA\Property(
     *                                 property="last_page_url",
     *                                 type="string",
     *                                 example="http://localhost:8000/api/admin/users/trashed?page=10"
     *                             ),
     *                             @OA\Property(
     *                                 property="options",
     *                                 type="object",
     *                                 @OA\Property(
     *                                     property="path",
     *                                     type="string",
     *                                     example="http://localhost:8000/api/admin/users/trashed"
     *                                 ),
     *                                 @OA\Property(
     *                                     property="pageName",
     *                                     type="string",
     *                                     example="users"
     *                                 ),
     *                             ),
     *                         ),
     *                         @OA\Property(
     *                             property="users",
     *                             type="array",
     *                             @OA\Items(
     *                                 @OA\Property(
     *                                     property="id",
     *                                     type="integer",
     *                                     example=1
     *                                 ),
     *                                 @OA\Property(
     *                                     property="name",
     *                                     type="string",
     *                                     example="John Doe"
     *                                 ),
     *                                 @OA\Property(
     *                                     property="email",
     *                                     type="string",
     *                                     example="QHs4o@example.com"
     *                                 ),
     *                                 @OA\Property(
     *                                     property="display_name",
     *                                     type="string",
     *                                     example="John Doe"
     *                                 ),
     *                                 @OA\Property(
     *                                     property="email_verified_at",
     *                                     type="string",
     *                                     example="2021-01-01 00:00:00"
     *                                 ),
     *                                 @OA\Property(
     *                                     property="gender",
     *                                     type="integer",
     *                                     example=1
     *                                 ),
     *                                 @OA\Property(
     *                                     property="active",
     *                                     type="integer",
     *                                     example=1
     *                                 ),
     *                                 @OA\Property(
     *                                     property="role",
     *                                     type="integer",
     *                                     example=1
     *                                 ),
     *                                 @OA\Property(
     *                                     property="created_at",
     *                                     type="string",
     *                                     example="2021-01-01 00:00:00"
     *                                 ),
     *                                 @OA\Property(
     *                                     property="updated_at",
     *                                     type="string",
     *                                     example="2021-01-01 00:00:00"
     *                                 ),
     *                                 @OA\Property(
     *                                     property="deleted_at",
     *                                     type="string",
     *                                     example="2021-01-01 00:00:00"
     *                                 ),
     *                             ),
     *                         ),
     *                     ),
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
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 example=null
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Invalid data"
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         @OA\Property(
     *                             property="page",
     *                             type="string",
     *                             example="page must be an integer"
     *                         ),
     *                         @OA\Property(
     *                             property="limit",
     *                             type="string",
     *                             example="limit must be an integer"
     *                         ),
     *                     ),
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
     *                 example=null
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Invalid token"
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="string",
     *                     example="The token could not be parsed from  the request",
     *                 ),
     *             ),
     *         ),
     *     ),
     * )
     */
    public function getAllTrashedUsers(Request $request)
    {
    }
}
