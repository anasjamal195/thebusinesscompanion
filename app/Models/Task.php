<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    protected $fillable = [
        'project_id',
        'user_id',
        'title',
        'input_text',
        'priority',
        'status',
        'context_snapshot',
    ];

    protected $casts = [
        'context_snapshot' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function output(): HasOne
    {
        return $this->hasOne(TaskOutput::class);
    }

    public function report(): HasOne
    {
        return $this->hasOne(Report::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(TaskLog::class);
    }
}
