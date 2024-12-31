<?php

namespace App\Http\Controllers\Admin;

use App\Helper\JsonResponseHelper;
use App\Http\Controllers\Controller;
use App\Repositories\Admin\AdminUserRepository;
use App\Validators\Admin\AdminUserValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    private $validator;

    private $repo;

    public function __construct(AdminUserValidator $validator, AdminUserRepository $repo)
    {
        $this->validator = $validator;
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
        $result = $this->getUser($request);

        return $this->repoResponse($result, 'Get user detail successfully');
    }

    /**
     * Get all users data (paginated)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllUsers(Request $request): JsonResponse
    {
        $validated = $this->validator->getAllUsers($request);

        if ($this->isJsonResponse($validated)) {
            return $validated;
        }

        $result = $this->repo->getAllUsers($request, $validated['order'], $validated['desc']);

        return $this->repoResponse($result, 'Get all users successfully');
    }

    /**
     * Get All inactive users (paginated)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInactiveUsers(Request $request): JsonResponse
    {
        $validated = $this->validator->getAllUsers($request);

        if ($this->isJsonResponse($validated)) {
            return $validated;
        }

        $result = $this->repo->getAllInactiveUsers($request, $validated['order'], $validated['desc']);

        return $this->repoResponse($result, 'Get all inactive users successfully');
    }

    /**
     * Get All non email validated users (paginated)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNonValidatedUsers(Request $request): JsonResponse
    {
        $validator = $this->validator->getAllUsers($request);

        if ($this->isJsonResponse($validator)) {
            return $validator;
        }

        $result = $this->repo->getNonValidatedUsers($request, $validator['order'], $validator['desc']);

        return $this->repoResponse($result, 'Get all non validated users successfully');
    }

    /**
     * Get all soft-deleted user (paginated)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllTrashedUsers(Request $request): JsonResponse
    {
        $validator = $this->validator->getAllUsers($request);

        if ($this->isJsonResponse($validator)) {
            return $validator;
        }

        $result = $this->repo->getAllTrashedUsers($request, $validator['order'], $validator['desc']);

        return $this->repoResponse($result, 'Get all trashed users successfully');
    }

    /**
     * Update user's profile (except for password, active, validate, delete, and role)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateUserProfile(Request $request): JsonResponse
    {
        $user = $this->getUser($request);

        if ($this->isJsonResponse($user)) {
            return $user;
        }

        $validator = $this->validator->updateUserProfile($request, $user);

        if ($this->isJsonResponse($validator)) {
            return $validator;
        }

        $result = $this->repo->updateUserProfile($user, $validator);

        return $this->repoResponse($result, 'Update user profile successfully');
    }

    /**
     * Update the password of a user.
     *
     * Validates the new password from the request and updates the user's password
     * if validation is successful. Returns a JSON response indicating the result
     * of the operation.
     *
     * @param \Illuminate\Http\Request $request The request object containing the new password.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the success or error message.
     */
    public function setPassword(Request $request): JsonResponse
    {
        $user = $this->getUser($request);

        if ($this->isJsonResponse($user)) {
            return $user;
        }

        $validator = $this->validator->setPassword($request);

        if ($this->isJsonResponse($validator)) {
            return $validator;
        }

        $result = $this->repo->updateUserProfile($user, $validator);

        return $this->repoResponse($result, 'Update user password successfully');
    }

    /**
     * Set user's verify or not
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setVerify(Request $request): JsonResponse
    {
        $user = $this->getUser($request);

        if ($this->isJsonResponse($user)) {
            return $user;
        }

        $validator = $this->validator->setVerify($request);

        if ($this->isJsonResponse($validator)) {
            return $validator;
        }

        $result = $this->repo->setVerify($user, (bool) $validator['validate']);

        return $this->repoResponse($result, 'Update user verify status successfully');
    }

    /**
     * Update the active status of a user.
     *
     * Validates the active status from the request and updates the user's active status
     * if validation is successful. Returns a JSON response indicating the result of the operation.
     *
     * @param \Illuminate\Http\Request $request The request object containing the active status.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the success or error message.
     */
    public function setActive(Request $request): JsonResponse
    {
        $user = $this->getUser($request);

        if ($this->isJsonResponse($user)) {
            return $user;
        }

        $validator = $this->validator->setActive($request);

        if ($this->isJsonResponse($validator)) {
            return $validator;
        }

        $result = $this->repo->setActive($user, (bool) $validator['active']);

        return $this->repoResponse($result, 'Update user active status successfully');
    }

    /**
     * Set user's trashed status.
     *
     * Validates the trashed status from the request and updates the user's trashed status
     * if validation is successful. Returns a JSON response indicating the result of the operation.
     *
     * @param \Illuminate\Http\Request $request The request object containing the trashed status.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the success or error message.
     */
    public function setTrash(Request $request): JsonResponse
    {
        $user = $this->getUser($request);

        if ($this->isJsonResponse($user)) {
            return $user;
        }

        $validator = $this->validator->setTrash($request);

        if ($this->isJsonResponse($validator)) {
            return $validator;
        }

        $result = $this->repo->setTrash($user, (bool) $validator['trash']);

        return $this->repoResponse($result, 'Update user trash status successfully');
    }

    private function getUser(Request $request): array|JsonResponse
    {
        $validator = $this->validator->getUserDetail($request);

        if ($this->isJsonResponse($validator)) {
            return $validator;
        }

        $user = $this->repo->getUserDetail($validator['user']);

        if (!$user) {
            return JsonResponseHelper::notFound('User not found');
        }

        return $user;
    }
}
