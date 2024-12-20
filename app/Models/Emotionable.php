<?php

namespace App\Models;

use App\Casts\ModelToTablename;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class Emotionable extends Model
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'user_id',
        'emotion_id',
        'emotionable_id',
        'emotionable_type',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'emotionable_type' => ModelToTablename::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function emotion(): BelongsTo
    {
        return $this->belongsTo(Emotion::class, 'emotion_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
