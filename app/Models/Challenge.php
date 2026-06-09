<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Challenge extends Model
{
    protected $fillable = [
        'name', 'description', 'slug', 'icon', 'start_date', 'end_date', 'requirements', 'is_active',
    ];

    protected $casts = [
        'requirements' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function participants(): HasMany
    {
        return $this->hasMany(ChallengeParticipant::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
