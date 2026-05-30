<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonetizationSetting extends Model
{
    protected $fillable = [
        'per_minute_rate',
        'minimum_refill',
    ];

    protected $casts = [
        'per_minute_rate' => 'decimal:2',
        'minimum_refill' => 'decimal:2',
    ];

    public static function getInstance(): self
    {
        return static::firstOrCreate([], [
            'per_minute_rate' => 1.00,
            'minimum_refill' => 5.00,
        ]);
    }
}
