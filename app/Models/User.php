<?php

namespace App\Models;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use SoftDeletes;
    use HasFactory;
    use Notifiable;
    use HasApiTokens;
    use MustVerifyEmail;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'display_name',
        'gender',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'deleted_at',
        'email_verified_at',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'gender' => 'integer',
            'active' => 'integer',
            'role' => 'integer',
        ];
    }

    /**
     * Get the posts created by the user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'author', 'id');
    }

    public function scopeAdmin(Builder|User $query): Builder
    {
        return $query->where('role', '>', 0);
    }

    public function scopeSuperAdmin(Builder|user $query): Builder
    {
        return $query->where('role', 2);
    }

    public function scopeActive(Builder|User $query): Builder
    {
        return $query->where('active', 1);
    }

    public function scopeCanLogin(Builder|User $query): Builder
    {
        return $query->where('active', 1)
            ->where('email_validated_at', '!=', null);
    }

    public function isAdmin(): bool
    {
        return $this->role > 0;
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 2;
    }

    public function isActive(): bool
    {
        return $this->active === 1;
    }

    public function isValidated(): bool
    {
        return $this->email_verified_at !== null && $this->active === 1;
    }

    /**
     * Get JWT identifier
     *
     * @return mixed
     */
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    /**
     * Add custom claims to JWT
     *
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [
            'role' => $this->role,
            'active' => $this->role_active,
        ];
    }
}
