<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserAchievement extends Pivot
{
    protected $table = 'user_achievements';

    protected $fillable = [
        'user_id', 'achievement_id', 'earned_at', 'is_shared', 'shared_at',
    ];

    protected $casts = [
        'earned_at' => 'datetime',
        'is_shared' => 'boolean',
        'shared_at' => 'datetime',
    ];
}
