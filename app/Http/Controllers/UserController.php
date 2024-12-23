<?php

namespace App\Http\Controllers;

use App\Helper\JsonResponseHelper;
use App\Repositories\UserRepository;
use App\Validators\UserValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $repo;

    protected $validator;

    protected $user;

    public function __construct(UserRepository $repo, UserValidator $validator)
    {
        $this->repo = $repo;
        $this->validator = $validator;
        $this->user = Auth::user();
    }

    /**
     * Get myself information
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(): JsonResponse
    {
        return JsonResponseHelper::success($this->user, 'Get myself information successfully');
    }

    /**
     * Change the authenticated user's password.
     *
     * Validates the request and updates the user's password if validation is successful.
     * Returns a JSON response indicating the result of the operation.
     *
     * @param \Illuminate\Http\Request $request The request object containing the current and new password.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the success or error message.
     */
    public function changePassword(Request $request): JsonResponse
    {
        $validated = $this->validator->changePasswordValidate($request);

        if ($this->isJsonResponse($validated)) {
            return $validated;
        }

        $user = $this->repo->changePassword(Auth::user(), $validated['password'], $validated['new_password']);

        return $this->repoResponse($user, 'Change password successfully');
    }

    /**
     * Update the authenticated user's profile information.
     *
     * Validates the request and updates the user's profile if validation is successful.
     * Returns a JSON response indicating the result of the operation.
     *
     * @param \Illuminate\Http\Request $request The request object containing profile data.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the success or error message.
     */
    public function updateProfile(Request $request)
    {
        $validate = $this->validator->updateProfileValidate($request, $this->user->id);

        if ($this->isJsonResponse($validate)) {
            return $validate;
        }

        $user = $this->repo->updateProfile($this->user, $validate);

        return $this->repoResponse($user, 'Update profile successfully');
    }

    public function getById(Request $request, int $userId): JsonResponse
    {
        $validator = $this->validator->getById($request, $userId, $this->user);

        if ($this->isJsonResponse($validator)) {
            return $validator;
        }

        $result = $this->repo->getById($validator);

        return $this->repoResponse($result, 'Get user by id successfully');
    }

    /**
     * Retrieve the posts associated with the authenticated user, filtered by the specified status.
     *
     * Depending on the filter provided, this method retrieves all posts, trashed posts, drafts, or published posts.
     * Results are ordered accordingly and, if 'all' is specified, grouped by publish status.
     *
     * @param \Illuminate\Http\Request $request The request object containing filter data.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the result of the operation.
     */
    public function getPosts(Request $request): JsonResponse
    {
        $validated = $this->validator->getPosts($request);

        if ($this->isJsonResponse($validated)) {
            return $validated;
        }

        $posts = $this->repo->getPosts($this->user, $validated['filter'] ?? 'published');

        return $this->repoResponse($posts, 'Get ' . ($validated['filter'] ?? 'published') . ' posts successfully');
    }

    /**
     * Retrieve all comments associated with the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response containing the result of the operation.
     */
    public function getComments(): JsonResponse
    {
        $result = $this->repo->getComments($this->user);

        return $this->repoResponse($result, 'Get comments successfully');
    }

    /**
     * Retrieve all emotions associated with the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response containing the result of the operation.
     */
    public function getEmotions(): JsonResponse
    {
        $result = $this->repo->getEmotions($this->user);

        return $this->repoResponse($result, 'Get emotions successfully');
    }

    /**
     * Retrieve all emotions associated with the authenticated user that the user has received.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response containing the result of the operation.
     */
    public function getEmotionsToMe(): JsonResponse
    {
        $result = $this->repo->getEmotionsToMe($this->user);

        return $this->repoResponse($result, 'Get emotions to me successfully');
    }
}
