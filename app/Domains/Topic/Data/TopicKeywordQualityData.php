<?php

namespace Domains\Topic\Data;

readonly class TopicKeywordQualityData
{
    public function __construct(

        public int $topicId,

        public string $topicName,

        public string $keyword,

        public int $weight,

        public int $matchCount,

        public float $singleKeywordPercentage,

        public float $qualityScore,

        public string $qualityGrade,
    ) {}
}
