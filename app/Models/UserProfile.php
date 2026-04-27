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
        'phone_number',
        'availability_hours',
        'max_call_duration',
        'daily_calling_limit',
        'business_url',
        'business_description',
        'current_problems',
        'urgent_tasks',
    ];

    protected $casts = [
        'availability_hours' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
