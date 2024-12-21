<?php

namespace App\Repositories;

use App\Helper\JsonResponseHelper;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserRepository extends BaseRepository
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }


    /**
     * Change the user's password.
     *
     * Checks the provided password against the user's current password,
     * and if valid, updates the user's password to the new one.
     *
     * @param User|Authenticatable $user The user to update
     * @param string $password The current password to check
     * @param string $newPassword The new password to set
     * @return User|JsonResponse The updated user on success, or a JSON response on failure
     */
    public function changePassword(User|Authenticatable $user, string $password, string $newPassword): User|JsonResponse
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
            Log::error('Change password failed', [
                'id' => $user->id,
                'password' => $password,
                'new_password' => $newPassword,
                'message' => $e->getMessage(),
            ]);
            return JsonResponseHelper::error($e->getMessage(), 'Change password failed');
        }
    }

    /**
     * Update the user's profile information.
     *
     * @param User|Authenticatable $user The user whose profile is to be updated.
     * @param array $profile An associative array containing the profile data to update.
     *
     * @return User|JsonResponse Returns the updated user object on success,
     * or a JsonResponse with an error message on failure.
     */
    public function updateProfile(User|Authenticatable $user, array $profile): User|JsonResponse
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
            Log::error('Update profile failed', [
                'id'=> $user->id,
                'message' => $e->getMessage(),
            ]);
            return JsonResponseHelper::error($e->getMessage(), 'Update profile failed');
        }
    }

    /**
     * Retrieve a user by their ID, with optional relationships.
     *
     * Retrieve a user by their ID, optionally including any of the following relationships:
     *     - posts
     *     - comments
     *     - receivedEmotions
     *     - givenEmotions
     *
     * @param array $validated An associative array containing the user ID and any
     *     optional relationships to include, with each relation name as a key and
     *     a value of 1 to include the relation.
     * @return array|JsonResponse Returns an associative array containing the user data,
     *     or a JSON response with an error message on failure.
     */
    public function getById(array $validated): array|JsonResponse
    {
        try {
            $userId = $validated['user_id'];
            $user = $this->model::find($userId);
            $relations = [];

            $includeRelations = Arr::except($validated, ['user_id']);
            foreach ($includeRelations as $relation => $shouldLoad) {
                if ($shouldLoad === 1) {
                    $relations[] = $relation;
                }
            }

            $user->load($relations);

            return $user->toArray();
        } catch (\Exception $exception) {
            Log::error('Failed to retrieve user by ID', [
                'user_id' => $userId,
                'data' => $validated,
                'error' => $exception->getMessage(),
            ]);
            return JsonResponseHelper::error(null, 'Failed to retrieve user by ID');
        }
    }

    /**
     * Retrieve the posts associated with a specific user, filtered by the specified status.
     *
     * Depending on the filter provided, this method retrieves all posts, trashed posts, drafts, or published posts.
     * Results are ordered accordingly and, if 'all' is specified, grouped by publish status.
     *
     * @param User|Authenticatable $user The user whose posts are to be retrieved.
     * @param string $filter The filter to apply. Can be 'all', 'trashed', 'draft', or 'published'.
     *
     * @return array|JsonResponse An array of posts or a JsonResponse in case of error or if the user is not found.
     */
    public function getPosts(User|Authenticatable $user, string $filter = 'published'): array|JsonResponse
    {
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

            return $result;
        } catch (\Exception $e) {
            Log::error('Get posts failed', [
                'id' => $user->id,
                'message' => $e->getMessage()
            ]);
            return JsonResponseHelper::error(null, 'Get posts failed');
        }
    }

    /**
     * Retrieve all comments made by the given user.
     *
     * If the user is not found or an error occurs, returns a JsonResponse with the error message.
     * Otherwise, returns an array of comments made by the user.
     *
     * @param User|Authenticatable $user The user whose comments are to be retrieved.
     * @return array|JsonResponse An array of comments or a JsonResponse in case of error.
     */
    public function getComments(User|Authenticatable $user): array|JsonResponse
    {
        try {
            return $user->load('comments')->toArray();
        } catch (\Exception $e) {
            Log::error('Get comments failed', [
                'id' => $user->id,
                'message' => $e->getMessage()
            ]);
            return JsonResponseHelper::error(null, 'Get comments failed');
        }
    }

    /**
     * Retrieve all emotions liked by the given user.
     *
     * If the user is not found or an error occurs, returns a JsonResponse with the error message.
     * Otherwise, returns an array of emotions liked by the user.
     *
     * @param User|Authenticatable $user The user whose emotions are to be retrieved.
     * @return array|JsonResponse An array of emotions liked by the user or a JsonResponse in case of error.
     */
    public function getEmotions(User|Authenticatable $user): array|JsonResponse
    {
        try {
            return $user->load('emotions')->toArray();
        } catch (\Exception $e) {
            Log::error('Get emotions failed', [
                'id' => $user->id,
                'message' => $e->getMessage()
            ]);
            return JsonResponseHelper::error(null, 'Get emotions failed');
        }
    }

    /**
     * Retrieve all emotions associated with the given user that the user has received.
     *
     * If the user is not found or an error occurs, returns a JsonResponse with the error message.
     * Otherwise, returns an array of emotions associated with the user that the user has received.
     *
     * @param User|Authenticatable $user The user whose received emotions are to be retrieved.
     * @return array|JsonResponse An array of received emotions or a JsonResponse in case of error.
     */
    public function getEmotionsToMe(User|Authenticatable $user): array|JsonResponse
    {
        try {
            return $user->load('emotionUsers')->toArray();
        } catch (\Exception $e) {
            Log::error('Get emotions to me failed', [
                'id' => $user->id,
                'message' => $e->getMessage()
            ]);
            return JsonResponseHelper::error(null, 'Get emotions to me failed');
        }
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
