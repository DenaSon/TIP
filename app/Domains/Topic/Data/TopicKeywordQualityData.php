<?php

namespace Domains\Topic\Data;

use Domains\Topic\Enums\KeywordQualityGrade;

readonly class TopicKeywordQualityData
{
    public function __construct(

        public int $topicId,
        public int $keywordId,

        public string $topicName,

        public string $keyword,

        public int $weight,

        public int $matchCount,

        public float $singleKeywordPercentage,

        public float $qualityScore,

        public KeywordQualityGrade $qualityGrade,
    ) {}
}
