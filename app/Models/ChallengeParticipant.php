<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChallengeParticipant extends Model
{
    protected $table = 'challenge_participants';

    protected $fillable = [
        'challenge_id', 'user_id', 'progress_data', 'joined_at', 'completed_at',
    ];

    protected $casts = [
        'progress_data' => 'array',
        'joined_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function challenge(): BelongsTo
    {
        return $this->belongsTo(Challenge::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
