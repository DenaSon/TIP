<?php
namespace Domains\Topic\Data;
use Domains\Topic\Enums\KeywordCandidateAction;
use Domains\Topic\Enums\KeywordGovernanceDecision;
use Domains\Topic\Enums\KeywordStatus;

readonly class TopicKeywordGovernanceData
{
    public function __construct(

        public int $keywordId,

        public int $topicId,

        public string $topicName,

        public string $keyword,

        public KeywordStatus $currentStatus,

        public KeywordStatus $recommendedStatus,

        public KeywordCandidateAction $action,

        public KeywordGovernanceDecision $decision,

        public int $confidenceScore,

        public bool $autoApplicable,

        public string $reason,
    ) {}
}
