<?php

namespace App\Repositories;

use App\Helper\JsonResponseHelper;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserRepository extends Repository
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Change the user's password.
     *
     * @param User|null $user the user to update.
     * @param string $password the current password.
     * @param string $newPassword the new password.
     *
     * @return User|JsonResponse if the password is changed successfully, the user object will be returned.
     * Otherwise, a JsonResponse with the error message will be returned.
     */
    public function changePassword(User|null $user, string $password, string $newPassword): User|JsonResponse
    {
        if (!$user) {
            return JsonResponseHelper::notFound('User not found');
        }

        if (!$this->checkPassword($user, $password)) {
            return JsonResponseHelper::error(null, 'The current password is incorrect');
        }

        try {
            DB::transaction(function () use (&$user, $newPassword) {
                $user->password = $newPassword;
                $user->save();
            });

            return $user;
        } catch (\Exception $e) {
            return JsonResponseHelper::error($e->getMessage(), 'Change password failed');
        }
    }

    /**
     * Update the user's profile information.
     *
     * @param User|null $user The user whose profile is to be updated.
     * @param array $profile An associative array containing the profile data to update.
     *
     * @return User|JsonResponse Returns the updated user object on success,
     * or a JsonResponse with an error message on failure.
     */
    public function updateProfile(User|null $user, array $profile): User|JsonResponse
    {
        if (!$user) {
            return JsonResponseHelper::notFound('User not found');
        }

        try {
            DB::transaction(function () use (&$user, $profile) {
                $user->update($profile);
            });

            return $user;
        } catch (\Exception $e) {
            return JsonResponseHelper::error($e->getMessage(), 'Update profile failed');
        }
    }

    /**
     * Retrieve the posts associated with a specific user, filtered by the specified status.
     *
     * Depending on the filter provided, this method retrieves all posts, trashed posts, drafts, or published posts.
     * Results are ordered accordingly and, if 'all' is specified, grouped by publish status.
     *
     * @param User|null $user The user whose posts are to be retrieved.
     * @param string $filter The filter to apply. Can be 'all', 'trashed', 'draft', or 'published'.
     *
     * @return array|JsonResponse An array of posts or a JsonResponse in case of error or if the user is not found.
     */
    public function getPosts(User|null $user, string $filter = 'published'): array|JsonResponse
    {
        if (!$user) {
            return JsonResponseHelper::notFound('User not found');
        }

        try {
            $result = $user::with([
                'posts' => function (HasMany $query) use ($filter) {
                    if ('all' === $filter) {
                        $query->orderBy('id');
                    } elseif ('trashed' === $filter) {
                        $query->where('publish_status', 0)->orderBy('created_at', 'desc');
                    } elseif ('draft' === $filter) {
                        $query->where('publish_status', 1)->orderBy('created_at', 'desc');
                    } else {
                        $query->where('publish_status', 2)->orderBy('created_at', 'desc');
                    }
                }
            ])->first()->toArray();

            if ('all' === $filter) {
                $result['posts'] = collect($result['posts'])->groupBy('publish_status')->toArray();
            }
        } catch (\Exception $e) {
            Log::error('Get posts failed', [
                'id' => $user->id,
                'message' => $e->getMessage()
            ]);
            return JsonResponseHelper::error(null, 'Get posts failed');
        }

        return $result;
    }

    /**
     * Check if the given password matches the user's password
     *
     * @param  User   $user
     * @param  string $password
     * @return bool
     */
    private function checkPassword(User $user, string $password): bool
    {
        return Hash::check($password, $user->password);
    }
}
