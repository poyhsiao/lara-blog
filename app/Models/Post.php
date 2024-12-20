<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

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
        'user_id',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    protected $casts = [
        'publish_status' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Post $post) {
            $post->slug = self::generateUniqueSlug($post->title);
        });
    }

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

    public function scopeAvailable(Builder|Post $query): Builder
    {
        return $query->where('publish_status', 2)
            ->where('deleted_at', null);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)
        ->withTimestamps();
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class)
        ->withTimestamps();
    }

    /**
     * The author of the post.
     *
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function emotionEmotions(): MorphToMany
    {
        return $this->morphToMany(Emotion::class, 'emotionable');
    }

    public function emotionUsers(): MorphToMany
    {
        return $this->morphToMany(User::class, 'emotionable');
    }

    private static function generateUniqueSlug(string $title): string
    {
        $slug = Str::substr(Str::slug($title), 0, 250);

        $i = 1;

        while (self::where('slug', $slug)->exists()) {
            $slug = "{$slug}-{$i}";
            $i++;
        }

        return $slug;
    }
}
