<?php

namespace App\Http\Controllers\Admin;

use App\Helper\JsonResponseHelper;
use App\Helper\QueryHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Admin\AdminUserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    protected $repo;

    public function __construct(AdminUserRepository $repo)
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

    /**
     * Update user's profile (except for password, active, validate, delete, and role)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateUserProfile(Request $request): JsonResponse
    {
        if (!$theUser = $this->validateGivenUser($request)) {
            return JsonResponseHelper::notFound('The user is not found or you don\'t have permission');
        }

        $data = $request->only(['name', 'email', 'display_name', 'gender']);

        $validator = Validator::make($data, [
            'name' => [
                'string',
                'between:2,255',
                Rule::unique('users', 'name')->ignore($theUser->id),
            ],
            'email' => [
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($theUser->id),
            ],
            'display_name' => [
                'string',
                'between:2,255',
                Rule::unique('users', 'display_name')->ignore($theUser->id),
            ],
            'gender' => 'enum:0,1,2',
        ]);

        if ($validator->fails()) {
            return JsonResponseHelper::notAcceptable('Unacceptable', $validator->errors());
        }

        if (!$user = $this->repo->updateUser($theUser, $data)) {
            return JsonResponseHelper::error('Update user failed');
        }

        return JsonResponseHelper::success(compact('user'), 'Update user successfully');
    }

    /**
     * Update user's password
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setPassword(Request $request): JsonResponse
    {
        if (!$theUser = $this->validateGivenUser($request)) {
            return JsonResponseHelper::notFound('The user is not found or you don\'t have permission');
        }

        $data = $request->only(['password']);

        $validator = Validator::make($data, [
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return JsonResponseHelper::notAcceptable('Unacceptable', $validator->errors());
        }

        if (!$user = $this->repo->updateUser($theUser, $data)) {
            return JsonResponseHelper::error('Update user failed');
        }

        return JsonResponseHelper::success(compact('user'), 'Update user successfully');
    }

    /**
     * Set user's verify or not
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setVerify(Request $request): JsonResponse
    {
        if (!$theUser = $this->validateGivenUser($request)) {
            return JsonResponseHelper::notFound('The user is not found or you don\'t have permission');
        }

        $data = $request->only(['verify']);

        $validator = Validator::make($data, [
            'verify' => 'required|in:0,1',
        ]);

        if ($validator->fails()) {
            return JsonResponseHelper::notAcceptable('Unacceptable', $validator->errors());
        }

        if (!$user = $this->repo->setVerify($theUser, (bool)$request->verify)) {
            return JsonResponseHelper::error('Update user failed');
        }

        return JsonResponseHelper::success(compact('user'), 'Update user successfully');
    }

    /**
     * Set user's active or not
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setActive(Request $request): JsonResponse
    {
        if (!$theUser = $this->validateGivenUser($request)) {
            return JsonResponseHelper::notFound('The user is not found or you don\'t have permission');
        }

        $data = $request->only(['active']);

        $validator = Validator::make($data, [
            'active' => 'required|in:0,1',
        ]);

        if ($validator->fails()) {
            return JsonResponseHelper::notAcceptable('Unacceptable', $validator->errors());
        }

        if (!$user = $this->repo->setActive($theUser, (bool) $request->active)) {
            return JsonResponseHelper::error('Update user failed');
        }

        return JsonResponseHelper::success(compact('user'), 'Update user successfully');
    }

    /**
     * Soft-delete or restore user
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setTrash(Request $request): JsonResponse
    {
        if (!$theUser = $this->validateGivenUser($request)) {
            return JsonResponseHelper::notFound('The user is not found or you don\'t have permission');
        }

        $data = $request->only(['trash']);

        $validator = Validator::make($data, [
            'trash' => 'required|in:0,1',
        ]);

        if ($validator->fails()) {
            return JsonResponseHelper::notAcceptable('Unacceptable', $validator->errors());
        }

        if (!$user = $this->repo->setTrash($theUser, (bool) $request->trash)) {
            return JsonResponseHelper::error('Update user failed');
        }

        return JsonResponseHelper::success(compact('user'), 'Update user successfully');
    }

    /**
     * Validate user and return the user
     *
     * @param \Illuminate\Http\Request $request
     * @return \App\Models\User|null
     */
    private function validateGivenUser(Request $request): ?User
    {
        $validate = Validator::make($request->all(), [
            'user' => 'required|string',
        ]);

        if ($validate->fails()) {
            return null;
        }

        try {
            return $this->repo->getUserDetail($request->user, true);
        } catch (\Exception $e) {
            return null;
        }
    }
}
