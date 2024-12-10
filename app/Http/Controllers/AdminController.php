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
     * Get All non email validated users (paginated)
     *
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
