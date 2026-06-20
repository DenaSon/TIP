<?php

namespace Domains\Topic\Services;

use Domains\Topic\Data\TopicKeywordGovernanceData;
use Domains\Topic\Enums\KeywordCandidateAction;
use Domains\Topic\Enums\KeywordGovernanceDecision;
use Domains\Topic\Enums\KeywordStatus;
use Domains\Topic\Models\Topic;

readonly class TopicKeywordGovernanceService
{
    private const int AUTO_APPLY_THRESHOLD = 80;

    public function __construct(
        private TopicKeywordCandidateService $candidateService,
        private TopicKeywordGovernanceScoreService $scoreService,
    ) {}

    /**
     * @return TopicKeywordGovernanceData[]
     */
    public function analyze(
        Topic $topic
    ): array {

        $candidates =
            $this->candidateService
                ->analyze($topic);

        $keywordStatuses =
            $topic->keywords
                ->mapWithKeys(
                    fn ($keyword) => [

                        $keyword->id => $keyword->status,
                    ]
                );

        $results = [];

        foreach ($candidates as $candidate) {

            $confidenceScore =
                $this->scoreService
                    ->score($candidate);

            $autoApplicable =
                $this->determineAutoApplicable(
                    $candidate->action,
                    $confidenceScore
                );

            $currentStatus =
                $keywordStatuses->get(
                    $candidate->keywordId,
                    KeywordStatus::Active
                );

            $recommendedStatus =
                $this->determineStatus(
                    $candidate->action
                );

            $results[] =
                new TopicKeywordGovernanceData(

                    keywordId: $candidate->keywordId,

                    topicId: $candidate->topicId,

                    topicName: $candidate->topicName,

                    keyword: $candidate->keyword,

                    currentStatus: $currentStatus,

                    recommendedStatus: $recommendedStatus,

                    action: $candidate->action,

                    decision: $autoApplicable
                        ? KeywordGovernanceDecision::AutoApprove
                        : KeywordGovernanceDecision::ManualReview,

                    confidenceScore: $confidenceScore,

                    autoApplicable: $autoApplicable,

                    reason: $candidate->reason,
                );
        }

        return $results;
    }

    private function determineAutoApplicable(
        KeywordCandidateAction $action,
        int $confidenceScore
    ): bool {

        return match ($action) {

            KeywordCandidateAction::Promote,

            KeywordCandidateAction::ReduceWeight => $confidenceScore
                >= self::AUTO_APPLY_THRESHOLD,

            KeywordCandidateAction::NotValidated => true,

            KeywordCandidateAction::Keep => false,

            KeywordCandidateAction::Remove => false,
        };
    }

    private function determineStatus(
        KeywordCandidateAction $action
    ): KeywordStatus {

        return match ($action) {

            KeywordCandidateAction::Promote => KeywordStatus::Promoted,

            KeywordCandidateAction::Keep => KeywordStatus::Active,

            KeywordCandidateAction::ReduceWeight => KeywordStatus::Deprecated,

            KeywordCandidateAction::Remove => KeywordStatus::Rejected,

            KeywordCandidateAction::NotValidated => KeywordStatus::Draft,
        };
    }
}
