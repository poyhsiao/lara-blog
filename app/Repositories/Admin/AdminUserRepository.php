<?php

namespace App\Repositories\Admin;

use App\Models\User;
use App\Repositories\Repository;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AdminUserRepository extends Repository
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Get all the user detail
     *
     * @param string $user
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function getUserDetail(string $user, bool $onlyNormal = false): ?User
    {
        try {
            if (is_numeric($user)) {
                $query = $this->model::withTrashed()
                ->where('id', $user);
                $query = $onlyNormal ? $query->where('role', 0) : $query;
            } else {
                $query = $this->model::withTrashed()
                ->where('email', $user)
                ->orWhere('name', $user);

                $query = $onlyNormal ? $query->where('role', 0) : $query;
            }

            $result = $query->firstOrFail();

            return ($result) ? $result->setHidden(['password', 'remember_token']) : null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get all the users
     *
     * @return \Illuminate\Contracts\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null
     */
    public function getAllUsers(string $orderBy = 'id', bool $desc = false): Builder|Model|null
    {
        try {
            return $this->model
              ->withTrashed()
              ->orderBy($orderBy, ($desc) ? 'desc' : 'asc');
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get all inactive users
     *
     * @param string $orderBy
     * @param bool $desc
     * @return \Illuminate\Contracts\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null
     */
    public function getAllInactiveUsers(string $orderBy = 'id', bool $desc = false): Builder|Model|null
    {
        try {
            return $this->model
              ->where('active', 0)
              ->orderBy($orderBy, ($desc) ? 'desc' : 'asc');
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get all users without email validated
     *
     * @param string $orderBy
     * @param bool $desc
     * @return \Illuminate\Contracts\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null
     */
    public function getNonValidatedUsers(string $orderBy = 'id', bool $desc = false): Builder|Model|null
    {
        try {
            return $this->model
              ->where('email_verified_at', null)
              ->orderBy($orderBy, ($desc) ? 'desc' : 'asc');
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get all soft-deleted users (paginated)
     *
     * @param string $orderBy
     * @param bool $desc
     * @return \Illuminate\Contracts\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null
     */
    public function getAllDeletedUsers(string $orderBy = 'id', bool $desc = false): Builder|Model|null
    {
        try {
            return $this->model
              ->onlyTrashed()
              ->orderBy($orderBy, ($desc) ? 'desc' : 'asc');
        } catch (\Exception $e) {
            return null;
        }
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
        $result = null;

        try {
            DB::transaction(function () use ($user, $data, &$result) {
                dump($data);
                $result = tap($user)->update($data);
            });
        } catch (\Exception $e) {
            return null;
        }

        return $result;
    }

    /**
     * Set user's verify or not
     *
     * @param \App\Models\User $user
     * @param bool $verify
     * @return User|null
     */
    public function setVerify(User $user, bool $verify): ?User
    {
        $result = null;

        try {
            DB::transaction(function () use ($user, $verify, &$result) {
                $user->email_verified_at = $verify ? now() : null;
                $user->save();

                $result = $user;
            });
        } catch (\Exception $e) {
            return null;
        }

        return $result;
    }

    /**
     * Set user active or not
     *
     * @param \App\Models\User $user
     * @param bool $active
     * @return User|null
     */
    public function setActive(User $user, bool $active): ?User
    {
        $result = null;

        try {
            DB::transaction(function () use ($user, $active, &$result) {
                $user->active = $active ? 1 : 0;
                $user->save();

                $result = $user;
            });
        } catch (\Exception $e) {
            return null;
        }

        return $result;
    }

    /**
     * Soft-delete or restore user
     *
     * @param \App\Models\User $user
     * @param bool $trash
     * @return User|null
     */
    public function setTrash(User $user, bool $trash): ?User
    {
        $result = null;

        try {
            DB::transaction(function () use ($user, $trash, &$result) {
                ($trash) ? $user->delete() : $user->withTrashed()->restore();
                $result = $user;
            });
        } catch (\Exception $e) {
            return null;
        }

        return $result;
    }
}
