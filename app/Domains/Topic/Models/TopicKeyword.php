<?php

namespace Domains\Topic\Models;

use Domains\Topic\Enums\KeywordStatus;
use Domains\Topic\Models\Topic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TopicKeyword extends Model
{
    protected function casts(): array
    {
        return [
            'status' => KeywordStatus::class,
            'weight' => 'integer',

        ];

    }

    protected $fillable = [
        'topic_id',
        'keyword',
        'weight',
        'status',
    ];

    public function topic(): BelongsTo
    {
        return $this->belongsTo(
            Topic::class
        );
    }
}
