<?php

namespace App\Http\Controllers;

use App\Helper\JsonResponseHelper;
use App\Helper\QueryHelper;
use App\Repositories\AdminRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    protected $repo;

    public function __construct(AdminRepository $repo)
    {
        $this->repo = $repo;
    }

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
     *
     * Get user detail by email, name, or id
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserDetail(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user' => 'required|string',
        ]);

        if ($validator->fails()) {
            return JsonResponseHelper::error($validator->errors(), 'Invalid data');
        }

        $user = $this->repo->getUserDetail($request->user);

        if (!$user) {
            return JsonResponseHelper::notFound('User not found');
        }

        return JsonResponseHelper::success(compact('user'), 'Get user successfully');
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
     *                                 example="http://localhost:8000/api/admin/users/all?page=2"
     *                             ),
     *                             @OA\Property(
     *                                 property="prev_page_url",
     *                                 type="string",
     *                                 example="http://localhost:8000/api/admin/users/all?page=1"
     *                             ),
     *                             @OA\Property(
     *                                 property="last_page_url",
     *                                 type="string",
     *                                 example="http://localhost:8000/api/admin/users/all?page=10"
     *                             ),
     *                             @OA\Property(
     *                                 property="options",
     *                                 type="object",
     *                                 @OA\Property(
     *                                     property="path",
     *                                     type="string",
     *                                     example="http://localhost:8000/api/admin/users/all"
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
     *
     * Get all users data (paginated)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllUsers(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'page' => 'integer|min:1',
            'limit' => 'integer|min:1',
            'order' => 'string',
            'detail' => 'integer|in:0,1',
            'desc' => 'integer|in:0,1',
        ]);

        if ($validator->fails()) {
            return JsonResponseHelper::error($validator->errors(), 'Invalid data');
        }

        $page = $request->page ?? 1;
        $limit = $request->limit ?? 10;
        $order = $request->order ?? 'id';
        $detail = (bool)$request->detail ?? false;
        $desc = (bool)$request->desc ?? false;

        $paginator = $this->repo
            ->getAllUsers($order, $desc)
            ->paginate($limit, ['*'], 'users', $page)
            ->withQueryString();

        $users = QueryHelper::easyPaginate($paginator, 'users', $detail, ['password', 'remember_token']);

        return JsonResponseHelper::success(compact('users'), 'Get all users successfully');
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
     *
     * Get All inactive users (paginated)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInactiveUsers(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'page' => 'integer|min:1',
            'limit' => 'integer|min:1',
            'order' => 'string',
            'detail' => 'integer|in:0,1',
            'desc' => 'integer|in:0,1',
        ]);

        if ($validator->fails()) {
            return JsonResponseHelper::error($validator->errors(), 'Invalid data');
        }

        $page = $request->page ?? 1;
        $limit = $request->limit ?? 10;
        $order = $request->order ?? 'id';
        $detail = (bool)$request->detail ?? false;
        $desc = (bool)$request->desc ?? false;

        $paginator = $this->repo
            ->getAllInactiveUsers($order, $desc)
            ->paginate($limit, ['*'], 'users', $page)
            ->withQueryString();

        $users = QueryHelper::easyPaginate($paginator, 'users', $detail, ['password', 'remember_token']);

        return JsonResponseHelper::success(compact('users'), 'Get all inactive users successfully');
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
     *
     * Get All non email validated users (paginated)
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNonValidatedUsers(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'page' => 'integer|min:1',
            'limit' => 'integer|min:1',
            'order' => 'string',
            'detail' => 'integer|in:0,1',
            'desc' => 'integer|in:0,1',
        ]);

        if ($validator->fails()) {
            return JsonResponseHelper::error($validator->errors(), 'Invalid data');
        }

        $page = $request->page ?? 1;
        $limit = $request->limit ?? 10;
        $order = $request->order ?? 'id';
        $detail = (bool)$request->detail ?? false;
        $desc = (bool)$request->desc ?? false;

        $paginator = $this->repo
            ->getNonValidatedUsers($order, $desc)
            ->paginate($limit, ['*'], 'users', $page)
            ->withQueryString();

        $users = QueryHelper::easyPaginate($paginator, 'users', $detail, ['password', 'remember_token']);

        return JsonResponseHelper::success(compact('users'), 'Get all non validated users successfully');
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
     *                     example="The token could not be parsed from the request",
     *                 ),
     *             ),
     *         ),
     *     ),
     * )
     *
     * Get all soft-deleted user (paginated)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllTrashedUsers(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'page' => 'integer|min:1',
            'limit' => 'integer|min:1',
            'order' => 'string',
            'detail' => 'integer|in:0,1',
            'desc' => 'integer|in:0,1',
        ]);

        if ($validator->fails()) {
            return JsonResponseHelper::error($validator->errors(), 'Invalid data');
        }

        $page = $request->page ?? 1;
        $limit = $request->limit ?? 10;
        $order = $request->order ?? 'id';
        $detail = (bool)$request->detail ?? false;
        $desc = (bool)$request->desc ?? false;

        $paginator = $this->repo
            ->getAllDeletedUsers($order, $desc)
            ->paginate($limit, ['*'], 'users', $page)
            ->withQueryString();

        $users = QueryHelper::easyPaginate($paginator, 'users', $detail, ['password', 'remember_token']);

        return JsonResponseHelper::success($users, 'Get all trashed users successfully');
    }
}
