<?php
namespace Domains\Topic\Models;

use Domains\Content\Models\Content;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContentTopicMatch extends Model
{
    protected $fillable = [

        'content_id',

        'topic_id',

        'score',

        'matched_keywords',
    ];

    protected function casts(): array
    {
        return [

            'matched_keywords' => 'array',
        ];
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(
            Topic::class
        );
    }

    public function content(): BelongsTo
    {
        return $this->belongsTo(
            Content::class
        );
    }
}
