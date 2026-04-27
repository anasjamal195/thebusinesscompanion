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
        'retell_agent_id', 'retell_llm_id',
    ];

    protected $casts = [
        'meta' => 'array',
    ];
}
