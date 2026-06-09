<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mentor extends Model
{
    protected $fillable = [
        'user_id', 'bio', 'specialties', 'is_active', 'mentees_count',
    ];

    protected $casts = [
        'specialties' => 'array',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
