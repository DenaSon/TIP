<?php

namespace Domains\Topic\Data;

readonly class TopicQualityData
{
    public function __construct(
        public int $topicId,
        public string $topicName,

        public int $coverage,

        public float $overlapPercentage,

        public float $averageScore,

        public float $medianScore,

        public float $averageKeywordCount,

        public int $sourceDiversity,

        public float $noiseRatio,
    ) {}
}
