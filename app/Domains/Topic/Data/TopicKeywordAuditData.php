<?php

namespace Domains\Topic\Data;

readonly class TopicKeywordAuditData
{
    public function __construct(

        public int $topicId,
        public int $keywordId,

        public string $topicName,

        public string $keyword,

        public int $weight,

        public int $matchCount,

        public int $singleKeywordMatchCount,

        public float $singleKeywordPercentage,
    ) {}
}
