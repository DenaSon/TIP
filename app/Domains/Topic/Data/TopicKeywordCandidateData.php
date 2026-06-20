<?php

namespace Domains\Topic\Data;

use Domains\Topic\Enums\KeywordCandidateAction;
use Domains\Topic\Enums\KeywordQualityGrade;

readonly class TopicKeywordCandidateData
{
    public function __construct(

        public int $topicId,

        public string $topicName,

        public string $keyword,

        public int $weight,

        public int $matchCount,

        public float $qualityScore,

        public KeywordQualityGrade $qualityGrade,

        public KeywordCandidateAction $action,

        public string $reason,
    ) {}
}
