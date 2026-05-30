<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CreditPurchase extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'credits_added',
        'stripe_session_id',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'credits_added' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
