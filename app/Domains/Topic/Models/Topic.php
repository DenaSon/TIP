<?php

namespace Domains\Topic\Models;

use Domains\Content\Models\Content;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Topic extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
    ];

    public function contents(): BelongsToMany
    {
        return $this->belongsToMany(
            Content::class
        );
    }
}
