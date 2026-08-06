<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'vapi_voice_id', 'provider', 'gender', 'accent', 'description', 'avatar_path', 'sample_path', 'is_active', 'sort_order'])]
class Voice extends Model
{
    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function getAvatarUrlAttribute(): ?string
    {
        if (!$this->avatar_path) {
            return null;
        }

        return '/storage/' . $this->avatar_path;
    }

    public function getSampleUrlAttribute(): ?string
    {
        if (!$this->sample_path) {
            return null;
        }

        return '/storage/' . $this->sample_path;
    }

    public function getGenderAttribute(?string $value): ?string
    {
        return $value ?: null;
    }

    public static function activeOrdered()
    {
        return static::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
    }
}