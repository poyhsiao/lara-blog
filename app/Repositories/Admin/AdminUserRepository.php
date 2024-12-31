<?php

namespace App\Repositories\Admin;

use App\Foundation\Helper\HashidTools;
use App\Helper\JsonResponseHelper;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class AdminUserRepository extends BaseRepository
{
    protected $model;

    protected $hash;

    public function __construct(User $model)
    {
        $this->model = $model;
        $hash = new HashidTools();
        $this->hash = $hash->connection('users');
    }

    /**
     * Get user detail by email, name, or id
     *
     * @param string $user Name, email, or id
     * @param bool $onlyNormal Whether to only retrieve normal users, default: false
     * @return array|JsonResponse The user detail or a JSON response with errors
     */
    public function getUserDetail(string $user, bool $onlyNormal = false): array|JsonResponse
    {
        try {
            if ($id = $this->hashToId($user)) {
                $user = ($onlyNormal) ?
                    $this->model::withTrashed()->findOrFail($id) :
                    $this->model::findOrFail($id);
            } else {
                $user = ($onlyNormal) ?
                $this->model::where('email', $user)
                    ->orWhere('name', $user)
                    ->firstOrFail() :
                $this->model::withTrashed()
                    ->where('email', $user)
                    ->where('email', $user)
                    ->orWhere('name', $user)
                    ->firstOrFail();
            }

            return $user->toArray();
        } catch (Throwable $e) {
            Log::error('Get user detail failed', [
                'user' => $user,
                'only_normal' => $onlyNormal,
                'message' => $e->getMessage(),
            ]);
            return JsonResponseHelper::error(null, 'Get user detail failed');
        }
    }

    /**
     * Retrieve all users (paginated)
     *
     * Retrieves all users from the database, allowing for optional ordering and direction of sorting. The result is paginated based on the request's parameters.
     *
     * @param \Illuminate\Http\Request $request The incoming request containing pagination data.
     * @param string $orderBy The field by which to order the users, default is 'id'.
     * @param bool $desc Whether to order the results in descending order, default is false.
     * @return array|JsonResponse An array of users if successful, or a JsonResponse with an error message if an error occurs.
     */
    public function getAllUsers(Request $request, string $orderBy = 'id', bool $desc = false): array|JsonResponse
    {
        try {
            $query = $this->model::withTrashed()
              ->orderBy($orderBy, ($desc) ? 'desc' : 'asc');
            $result = $query->get()->toArray();

            return $this->paginateArray($request, $result, 'users');
        } catch (Throwable $e) {
            Log::error('Get all users failed', [
                'request' => $request,
                'orderBy' => $orderBy,
                'desc' => $desc,
                'message' => $e->getMessage(),
            ]);
            return JsonResponseHelper::error(null, 'Get all users failed');
        }
    }

    /**
     * Retrieve all inactive users (paginated)
     *
     * Retrieves all inactive users from the database, allowing for optional
     * ordering and direction of sorting. The result is paginated based on
     * the request's parameters.
     *
     * @param \Illuminate\Http\Request $request The incoming request containing pagination data.
     * @param string $orderBy The field by which to order the users, default is 'id'.
     * @param bool $desc Whether to order the results in descending order, default is false.
     * @return array|JsonResponse An array of users if successful, or a JsonResponse with an error message if an error occurs.
     */
    public function getAllInactiveUsers(Request $request, string $orderBy = 'id', bool $desc = false): array|JsonResponse
    {
        try {
            $users = $this->model::inactive()
                ->orderBy($orderBy, ($desc) ? 'desc' : 'asc')
                ->get()
                ->toArray();

            return $this->paginateArray($request, $users, 'users');
        } catch (Throwable $e) {
            Log::error('Get all inactive users failed', [
                'request' => $request,
                'orderBy' => $orderBy,
                'desc' => $desc,
                'message' => $e->getMessage(),
            ]);
            return JsonResponseHelper::error(null, 'Get all inactive users failed');
        }
    }

    /**
     * Retrieve all non-verified users (paginated)
     *
     * Retrieves all users which have not verified their email address from the database,
     * and paginates the result. The result is paginated based on the request's parameters.
     *
     * @param \Illuminate\Http\Request $request The incoming request containing pagination data.
     * @param string $orderBy The field by which to order the users, default is 'id'.
     * @param bool $desc Whether to order the results in descending order, default is false.
     * @return array|JsonResponse An array of users if successful, or a JsonResponse with an error message if an error occurs.
     */
    public function getNonValidatedUsers(Request $request, string $orderBy = 'id', bool $desc = false): array|JsonResponse
    {
        try {
            $users = $this->model::notVerified()
              ->orderBy($orderBy, ($desc) ? 'desc' : 'asc')
              ->get()
              ->toArray();

            return $this->paginateArray($request, $users, 'users');
        } catch (Throwable $e) {
            Log::error('Get non validated users failed', [
                'request' => $request,
                'orderBy' => $orderBy,
                'desc' => $desc,
                'message' => $e->getMessage(),
            ]);
            return JsonResponseHelper::error(null, 'Get non validated users failed');
        }
    }

    /**
     * Get all soft-deleted users (paginated)
     *
     * Retrieves all soft-deleted users from the database, and paginates the result.
     * The result is paginated based on the request's parameters.
     *
     * @param \Illuminate\Http\Request $request The incoming request containing pagination data.
     * @param string $orderBy The field by which to order the users, default is 'id'.
     * @param bool $desc Whether to order the results in descending order, default is false.
     * @return array|JsonResponse An array of users if successful, or a JsonResponse with an error message if an error occurs.
     */
    public function getAllTrashedUsers(Request $request, string $orderBy = 'id', bool $desc = false): array|JsonResponse
    {
        try {
            $users = $this->model::onlyTrashed()
              ->orderBy($orderBy, ($desc) ? 'desc' : 'asc')
              ->get()
              ->toArray();

            return $this->paginateArray($request, $users, 'users');
        } catch (Throwable $e) {
            Log::error('Get all deleted users failed', [
                'request' => $request,
                'orderBy' => $orderBy,
                'desc' => $desc,
                'message' => $e->getMessage(),
            ]);
            return JsonResponseHelper::error(null, 'Get all deleted users failed');
        }
    }

    /**
     * Update a user's profile information.
     *
     * Updates the user in the database with the provided validated data.
     * If the update fails, logs the error and returns a JSON response with an error message.
     *
     * @param array $user The user data to update.
     * @param array $validated The validated data to update the user with.
     * @return array|JsonResponse The updated user data if successful, or a JsonResponse with an error message if an error occurs.
     */
    public function updateUserProfile(array $user, array $validated): array|JsonResponse
    {
        try {
            $userId = $this->hashToId($user['id']);
            $user = $this->model::find($userId);

            DB::transaction(function () use (&$user, $validated) {
                $user->update($validated);
            });

            return $user->toArray();
        } catch (Throwable $e) {
            Log::error('Update user profile failed', [
                'user' => $user,
                'validated' => $validated,
                'message' => $e->getMessage(),
            ]);
            return JsonResponseHelper::error(null, 'Update user profile failed');
        };
    }

    /**
     * Update user's data
     *
     * @param \App\Models\User $user
     * @param array $data
     * @return User|null
     */
    public function updateUser(User $user, array $data): ?User
    {
        try {
            DB::transaction(function () use ($user, $data, &$result) {
                $result = tap($user)->update($data);
            });
        } catch (\Exception $e) {
            return null;
        }

        return $result;
    }

    /**
     * Set user's email verification status.
     *
     * Tries to find the user with the given id, and then sets the email verification status accordingly. If the user is not found, logs an error and returns a JSON response with an error message. If an exception occurs during the update, logs the error and returns a JSON response with an error message. Otherwise, returns the updated user data as an array.
     *
     * @param array $user The user array containing the 'id' key.
     * @param bool $verify The verification status.
     * @return array|JsonResponse The updated user's data as an array on success, or a JsonResponse with an error message on failure.
     */
    public function setVerify(array $user, bool $verify)
    {
        try {
            $userId = $this->hashToId($user['id']);
            $user = $this->model::find($userId);

            DB::transaction(function () use (&$user, $verify) {
                $user->email_verified_at = $verify ? now() : null;
                $user->save();
            });

            return $user->toArray();
        } catch (Throwable $e) {
            Log::error('Set verify failed', [
                'user' => $user,
                'verify' => $verify,
                'message' => $e->getMessage(),
            ]);
            return JsonResponseHelper::error(null, 'Set verify failed');
        }
    }

    /**
     * Set the active status of a user.
     *
     * Attempts to update the active status of the specified user.
     * If the user is found, updates the active status within a database transaction.
     * Returns the updated user data as an array on success.
     * Logs an error and returns a JSON response with an error message if the user is not found
     * or if an exception occurs during the update.
     *
     * @param array $user The user array containing the 'id' key.
     * @param bool $active The active status to set (true for active, false for inactive).
     * @return array|JsonResponse The updated user's data as an array on success, or a JsonResponse with an error message on failure.
     */
    public function setActive(array $user, bool $active): array|JsonResponse
    {
        try {
            $userId = $this->hashToId($user['id']);
            $user = $this->model::find($userId);

            DB::transaction(function () use (&$user, $active) {
                $user->active = $active;
                $user->save();
            });

            return $user->toArray();
        } catch (Throwable $e) {
            Log::error('Set active failed', [
                'user' => $user,
                'active' => $active,
                'message' => $e->getMessage(),
            ]);
            return JsonResponseHelper::error(null, 'Set active failed');
        }
    }

    /**
     * Set the trashed status of a user.
     *
     * This method takes a user array and a boolean indicating whether to trash or restore the user.
     * If the trash flag is true, the user is soft-deleted; otherwise, the user is restored.
     * The operation is performed within a database transaction to ensure data integrity.
     * Returns the updated user's data as an array on success.
     * Logs an error and returns a JSON response with an error message if the user is not found
     * or if an exception occurs during the operation.
     *
     * @param array $user The user array containing the 'id' key.
     * @param bool $trash The trashed status to set (true for trashed, false for restored).
     * @return array|JsonResponse The updated user's data as an array on success, or a JsonResponse with an error message on failure.
     */
    public function setTrash(array $user, bool $trash): array|JsonResponse
    {
        try {
            $userId = $this->hashToId($user['id']);
            $user = $this->model::find($userId);

            DB::transaction(function () use (&$user, $trash) {
                if ($trash) {
                    $user->delete();
                } else {
                    $user->restore();
                }
            });

            return $user->toArray();
        } catch (Throwable $e) {
            Log::error('Set trash failed', [
                'user' => $user,
                'trash' => $trash,
                'message' => $e->getMessage(),
            ]);
            return JsonResponseHelper::error(null, 'Set trash failed');
        }
    }

    private function hashToId(string $hash): ?int
    {
        $code = $this->hash->decode($hash);
        return ($code) ? $code[0] : null;
    }
}
