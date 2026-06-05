<?php

namespace Domains\Content\Models;

use Domains\Source\Models\Source;
use Domains\Topic\Models\Topic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Content extends Model
{
    protected $fillable = [
        'source_id',
        'external_id',
        'title',
        'url',
        'excerpt',
        'content',
        'raw_payload',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'raw_payload' => 'array',
            'published_at' => 'datetime',
        ];
    }


    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }

    public function topics(): BelongsToMany
    {
        return $this->belongsToMany(
            Topic::class
        );
    }

}
