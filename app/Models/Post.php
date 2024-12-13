<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Post extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'publish_status',
        'author',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    protected $casts = [
        'publish_status' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the human-readable publish status for the post.
     *
     * Converts the integer publish status value into a string representation.
     * The possible statuses are:
     * - 0: 'Trashed'
     * - 1: 'Draft'
     * - 2: 'Published'
     *
     * @return Attribute
     */
    protected function publishStatus(): Attribute
    {
        return Attribute::make(
            get: function (int $value): string {
                switch ($value) {
                    case 0:
                        return 'Trashed';
                    case 1:
                        return 'Draft';
                    case 2:
                    default:
                        return 'Published';
                }
            },
        );
    }

    public function comments(): BelongsToMany
    {
        return $this->belongsToMany(Comment::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function category(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * The author of the post.
     *
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author', 'id');
    }
}
