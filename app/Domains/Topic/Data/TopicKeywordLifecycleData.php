<?php

namespace Domains\Topic\Data;

use Domains\Topic\Enums\KeywordCandidateAction;
use Domains\Topic\Enums\KeywordStatus;

readonly class TopicKeywordLifecycleData
{
    public function __construct(

        public int $topicId,
        public int $keywordId,

        public string $topicName,

        public string $keyword,

        public KeywordStatus $currentStatus,

        public KeywordStatus $recommendedStatus,

        public KeywordCandidateAction $action,

        public string $reason,
    ) {}
}
