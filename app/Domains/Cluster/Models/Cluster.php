<?php

namespace Domains\Cluster\Models;

use Domains\Content\Models\Content;
use Domains\Topic\Models\Topic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cluster extends Model
{
    protected $fillable = [
        'topic_id',
        'name',
        'content_count',
        'last_content_at',
    ];

    protected function casts(): array
    {
        return [
            'last_content_at' => 'datetime',
        ];
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(
            Topic::class
        );
    }

    public function contents(): BelongsToMany
    {
        return $this->belongsToMany(
            Content::class,
            'cluster_content'
        )
            ->withTimestamps();
    }
}
