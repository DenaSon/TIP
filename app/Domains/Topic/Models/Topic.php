<?php

namespace Domains\Topic\Models;

use App\Domains\Topic\Models\TopicKeyword;
use Domains\Cluster\Models\Cluster;
use Domains\Content\Models\Content;
use Domains\Trend\Models\TrendSnapshot;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function clusters(): HasMany
    {
        return $this->hasMany(
            Cluster::class
        );
    }

    public function keywords()
    {
        return $this->hasMany(
            TopicKeyword::class
        );
    }

    public function snapshots(): HasMany
    {
        return $this->hasMany(
            TrendSnapshot::class
        );
    }
}
