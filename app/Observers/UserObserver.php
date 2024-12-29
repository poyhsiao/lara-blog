<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserObserver
{
    protected $ttl;

    public function __construct()
    {
        $this->ttl = config('cache.default_ttl');
    }

    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        Cache::put('user.id.' . $user->id, $user->toArray(), $this->ttl);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        Cache::put('user.id.' . $user->id, $user->toArray(), $this->ttl);
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        Cache::forget('user.id.' . $user->id);
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        Cache::put('user.id.' . $user->id, $user->toArray(), $this->ttl);
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        Cache::forget('user.id.'. $user->id);
    }
}
