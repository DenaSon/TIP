<?php

namespace Domains\Opportunity\Models;

use Domains\Topic\Models\Topic;
use Domains\Trend\Models\Trend;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Opportunity extends Model
{
    protected $fillable = [

        'topic_id',

        'trend_id',

        'title',

        'score',

        'reason',

        'detected_at',
    ];

    protected function casts(): array
    {
        return [

            'score' => 'float',

            'detected_at' => 'datetime',
        ];
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(
            Topic::class
        );
    }

    public function trend(): BelongsTo
    {
        return $this->belongsTo(
            Trend::class
        );
    }
}
