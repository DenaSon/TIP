<?php

namespace Domains\Topic\Data;

readonly class TopicOverlapData
{
    public function __construct(
        public int $topicId,
        public string $topicName,

        public int $overlappingTopicId,
        public string $overlappingTopicName,

        public int $sharedContents,

        public float $overlapPercentage,
    ) {}
}
