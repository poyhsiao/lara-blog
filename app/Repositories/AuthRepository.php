<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class AuthRepository extends BaseRepository
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * User create
     *
     * @param array $data
     * @return User|null
     */
    public function create(array $data): ?User
    {
        $user = null;

        try {
            DB::transaction(function () use ($data, &$user) {
                $user = $this->model
                  ->create($data);
            });
        } catch (\Exception $e) {
            return null;
        }

        return $user;
    }
}
