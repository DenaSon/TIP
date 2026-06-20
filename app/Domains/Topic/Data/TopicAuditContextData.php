<?php

namespace Domains\Topic\Data;

readonly class TopicAuditContextData
{
    public function __construct(

        public int $topicId,

        public string $topicName,

        public float $medianScore,

        public bool $requiresReview,
    ) {}
}
