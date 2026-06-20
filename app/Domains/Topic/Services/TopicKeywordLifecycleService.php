<?php

namespace Domains\Topic\Services;

use Domains\Topic\Data\TopicKeywordLifecycleData;
use Domains\Topic\Enums\KeywordCandidateAction;
use Domains\Topic\Enums\KeywordStatus;
use Domains\Topic\Models\Topic;

readonly class TopicKeywordLifecycleService
{
    public function __construct(
        private TopicKeywordCandidateService $candidateService,
    ) {}

    /**
     * @return TopicKeywordLifecycleData[]
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

            $currentStatus =
                $keywordStatuses->get(
                    $candidate->keywordId,
                    KeywordStatus::Active
                );

            $results[] =
                new TopicKeywordLifecycleData(

                    topicId: $candidate->topicId,

                    keywordId: $candidate->keywordId,

                    topicName: $candidate->topicName,

                    keyword: $candidate->keyword,

                    currentStatus: $currentStatus,

                    recommendedStatus: $this->determineStatus(
                        $candidate->action
                    ),

                    action: $candidate->action,

                    reason: $candidate->reason,
                );
        }

        return $results;
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
