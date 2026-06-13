<?php

namespace Domains\Source\Models;

use Domains\Content\Models\Content;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Source extends Model
{
    use SoftDeletes;

    public const string TYPE_RSS = 'rss';

    public const string TYPE_TELEGRAM = 'telegram';

    public const string STATUS_ACTIVE = 'active';

    public const string STATUS_INACTIVE = 'inactive';

    protected $fillable = [
        'name',
        'type',
        'status',
        'config',
        'authority_score',
        'last_crawled_at',
    ];

    public function getUrlAttribute(): ?string
    {
        return $this->config['url'] ?? null;
    }

    protected function casts(): array
    {
        return [
            'config' => 'array',
            'last_crawled_at' => 'datetime',
        ];
    }

    public function toggleStatus(): bool
    {
        return $this->update([
            'status' => $this->isActive()
                ? self::STATUS_INACTIVE
                : self::STATUS_ACTIVE,
        ]);
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public static function availableTypes(): array
    {
        return [
            self::TYPE_RSS,
            self::TYPE_TELEGRAM,
        ];
    }

    public static function availableStatuses(): array
    {
        return [
            self::STATUS_ACTIVE,
            self::STATUS_INACTIVE,
        ];
    }

    public function isDeleted(): bool
    {
        return $this->deleted_at !== null;
    }

    public function contents(): HasMany
    {
        return $this->hasMany(Content::class);

    }

    public function feedUrl(): ?string
    {
        return $this->config['url'] ?? null;
    }

    public function isTrusted(): bool
    {
        return $this->authority_score >= 80;
    }

    public function isLowQuality(): bool
    {
        return $this->authority_score < 40;
    }
}
