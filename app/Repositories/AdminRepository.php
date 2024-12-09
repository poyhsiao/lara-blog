<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class AdminRepository extends Repository
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
  public function getUserDetail(string $user): ?User
  {
    try {
      if (is_numeric($user)) {
        $result = User::withTrashed()
          ->find($user);
      } else {
        $result = User::withTrashed()
          ->where('email', $user)
          ->orWhere('name', $user)
          ->first();
      }

      return ($result) ? $result->setHidden(['password']): null;
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
}