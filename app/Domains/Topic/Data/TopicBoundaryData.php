<?php

namespace Domains\Topic\Data;

readonly class TopicBoundaryData
{
    public function __construct(
        public int $topicId,
        public string $topicName,

        public float $boundaryScore,

        public string $boundaryStatus,

        public ?string $highestOverlapTopic,

        public float $highestOverlapPercentage,
    ) {}
}
