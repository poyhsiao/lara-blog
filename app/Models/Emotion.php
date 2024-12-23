<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Emotion extends Model
{
    /** @use HasFactory<\Database\Factories\EmotionFactory> */
    use HasFactory;
    use SoftDeletes;
    use Notifiable;

    protected $fillable = [
        'name',
        'description',
        'avatar',
        'user_id',
        'emotionable_id',
        'emotionable_type',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'laravel_through_key',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function emotionable(): MorphTo
    {
        return $this->morphTo();
    }

    public function scopeAvailable(Builder|Emotion $query): Builder
    {
        return $query->where('deleted_at', null);
    }

    public function scopeTrashed(Builder|Emotion $query): Builder
    {
        return $query->whereNotNull('deleted_at');
    }

    public function isAvailable(): bool
    {
        return $this->deleted_at === null;
    }

    public function posts(): MorphToMany
    {
        return $this->morphedByMany(Post::class, 'emotionable');
    }

    public function comments(): MorphToMany
    {
        return $this->morphedByMany(Comment::class, 'emotionable');
    }

    public function users(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, Emotionable::class, 'emotion_id', 'id');
    }
}
