<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Comment extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'content',
        'type',
        'replyable',
        'parent',
        'likes',
        'dislikes',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    protected $casts = [
        'parent' => 'integer',
        'likes' => 'integer',
        'dislikes' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function childComments(): HasMany
    {
        return $this->hasMany(Comment::class,'parent','id')
        ->orderBy('id','desc');
    }

    public function parentComment(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent', 'id');
    }

    public function scopeAvailable(Builder|Comment $query): Builder
    {
        return $query->where('deleted_at', null);
    }

    public function scopeReplyable(Builder|Comment $query): Builder
    {
        return $query->where('replyable', 1)
        ->whereNot('deleted_at', null);
    }
}
