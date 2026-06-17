<?php

namespace Domains\Trend\Models;

use Domains\Opportunity\Models\Opportunity;
use Domains\Topic\Models\Topic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Trend extends Model
{
    protected $fillable = [
        'topic_id',
        'growth_rate',
        'velocity',
        'acceleration',
        'authority_score',
        'score',
        'calculated_at',

    ];

    protected function casts(): array
    {
        return [

            'growth_rate' => 'float',

            'velocity' => 'float',

            'acceleration' => 'float',

            'authority_score' => 'float',

            'score' => 'float',

            'calculated_at' => 'datetime',
        ];
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(
            Topic::class
        );
    }

    public function opportunity(): HasOne
    {
        return $this->hasOne(
            Opportunity::class
        );
    }
}
