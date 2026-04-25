<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'business_name',
        'business_type',
        'industry',
        'target_audience',
        'goals',
        'challenges',
        'experience_level',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
