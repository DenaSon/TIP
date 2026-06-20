<?php

namespace Domains\Topic\Data;

readonly class TopicMatchAuditData
{
    public function __construct(

        public int $contentId,

        public int $topicId,

        public string $topicName,

        public int $score,

        public int $keywordCount,

        public float $confidenceScore,

        public bool $requiresReview,

        public array $reasons,
    ) {}
}
