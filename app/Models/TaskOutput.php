<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskOutput extends Model
{
    protected $fillable = [
        'task_id',
        'output_text',
        'structured_data',
    ];

    protected $casts = [
        'structured_data' => 'array',
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
