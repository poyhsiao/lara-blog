<?php

namespace App\Repositories;

use App\Helper\JsonResponseHelper;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
