<?php

namespace Domains\Source\Models;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    public const string TYPE_RSS = 'rss';

    public const string TYPE_TELEGRAM = 'telegram';

    public const string STATUS_ACTIVE = 'active';

    public const string STATUS_INACTIVE = 'inactive';

    protected $fillable = [
        'name',
        'type',
        'status',
        'config',
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

}
