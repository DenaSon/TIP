<?php

namespace Domains\Trend\Models;

use Domains\Topic\Models\Topic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trend extends Model
{
    protected $fillable = [
        'topic_id',
        'score',
        'contents_count',
        'calculated_at',
    ];

    protected function casts(): array
    {
        return [
            'calculated_at' => 'datetime',
        ];
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(
            Topic::class
        );
    }

    public function trend()
    {
        return $this->hasOne(
            Trend::class
        );
    }
}
