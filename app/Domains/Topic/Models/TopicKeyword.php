<?php

namespace App\Domains\Topic\Models;

use Domains\Topic\Models\Topic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TopicKeyword extends Model
{
    protected $fillable = [
        'topic_id',
        'keyword',
        'weight',
    ];

    public function topic(): BelongsTo
    {
        return $this->belongsTo(
            Topic::class
        );
    }
}
