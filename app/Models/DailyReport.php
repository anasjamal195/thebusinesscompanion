<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyReport extends Model
{
    protected $fillable = [
        'user_id',
        'report_date',
        'summary',
        'tasks_data',
        'total_tasks',
        'completed_tasks',
        'pending_tasks',
        'discarded_tasks',
    ];

    protected $casts = [
        'tasks_data' => 'array',
        'report_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
