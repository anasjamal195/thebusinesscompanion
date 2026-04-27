<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Call extends Model
{
    protected $fillable = [
        'call_id',
        'user_id',
        'ai_character_id',
        'status',
        'direction',
        'transcript',
        'recording_url',
        'metadata',
        'duration',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function character(): BelongsTo
    {
        return $this->belongsTo(AiCharacter::class, 'ai_character_id');
    }
}
