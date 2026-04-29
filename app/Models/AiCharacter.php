<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiCharacter extends Model
{
    protected $fillable = [
        'key',
        'occupation',
        'name',
        'tagline',
        'bio',
        'system_prompt',
        'avatar_url',
        'meta',
        'monthly_price',
        'is_premium',
        'stripe_price_id',
        'vapi_assistant_id',
    ];

    protected $casts = [
        'meta' => 'array',
    ];
}
