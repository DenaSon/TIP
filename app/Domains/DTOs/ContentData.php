<?php

namespace Domains\DTOs;

readonly class ContentData
{
    public function __construct(
        public int $sourceId,
        public ?string $externalId,
        public string $title,
        public ?string $url,
        public ?string $excerpt,
        public ?string $content,
        public array $rawPayload,
        public ?string $publishedAt,
    ) {}
}
