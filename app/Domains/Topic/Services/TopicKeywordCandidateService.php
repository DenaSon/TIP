<?php

namespace Domains\Topic\Services;

use Domains\Topic\Data\TopicKeywordCandidateData;
use Domains\Topic\Data\TopicKeywordQualityData;
use Domains\Topic\Enums\KeywordCandidateAction;
use Domains\Topic\Enums\KeywordQualityGrade;
use Domains\Topic\Models\Topic;

readonly class TopicKeywordCandidateService
{
    private const int STRATEGIC_WEIGHT = 80;

    public function __construct(
        private TopicKeywordQualityService $qualityService,
    ) {}

    /**
     * @return TopicKeywordCandidateData[]
     */
    public function analyze(
        Topic $topic
    ): array {

        $qualities =
            $this->qualityService
                ->analyze($topic);

        $results = [];

        foreach ($qualities as $quality) {

            $decision =
                $this->determineAction(
                    $quality
                );

            $results[] =
                new TopicKeywordCandidateData(

                    topicId: $quality->topicId,

                    keywordId: $quality->keywordId,

                    singleKeywordPercentage: $quality->singleKeywordPercentage,

                    topicName: $quality->topicName,

                    keyword: $quality->keyword,

                    weight: $quality->weight,

                    matchCount: $quality->matchCount,

                    qualityScore: $quality->qualityScore,

                    qualityGrade: $quality->qualityGrade,

                    action: $decision['action'],

                    reason: $decision['reason'],
                );
        }

        usort(
            $results,
            fn (
                TopicKeywordCandidateData $a,
                TopicKeywordCandidateData $b
            ) => strcmp(
                $a->action->value,
                $b->action->value
            )
        );

        return $results;
    }

    /**
     * @return array{
     *     action: KeywordCandidateAction,
     *     reason: string
     * }
     */
    private function determineAction(
        TopicKeywordQualityData $quality
    ): array {

        if (
            $quality->qualityGrade
            === KeywordQualityGrade::NotValidated
        ) {

            return [

                'action' => KeywordCandidateAction::NotValidated,

                'reason' => 'No matching content found',
            ];
        }

        if (
            $quality->qualityGrade
            === KeywordQualityGrade::Excellent
            &&
            $quality->matchCount >= 10
            &&
            $quality->singleKeywordPercentage <= 30
        ) {

            return [

                'action' => KeywordCandidateAction::Promote,

                'reason' => 'Strong and reliable keyword',
            ];
        }

        /*
         |----------------------------------------------------------
         | Strategic Keywords
         |----------------------------------------------------------
         */

        if (
            $quality->weight >= self::STRATEGIC_WEIGHT
        ) {

            if (
                $quality->qualityGrade
                === KeywordQualityGrade::Weak
            ) {

                return [

                    'action' => KeywordCandidateAction::ReduceWeight,

                    'reason' => 'Strategic keyword with low validation',
                ];
            }

            return [

                'action' => KeywordCandidateAction::Keep,

                'reason' => 'Strategic keyword',
            ];
        }

        /*
         |----------------------------------------------------------
         | Weak Keywords
         |----------------------------------------------------------
         */

        if (
            $quality->qualityGrade
            === KeywordQualityGrade::Weak
            &&
            $quality->matchCount <= 3
        ) {

            return [

                'action' => KeywordCandidateAction::Remove,

                'reason' => 'Very low usage and weak quality',
            ];
        }

        /*
         |----------------------------------------------------------
         | Needs Review
         |----------------------------------------------------------
         */

        if (
            $quality->qualityGrade
            === KeywordQualityGrade::NeedsReview
        ) {

            return [

                'action' => KeywordCandidateAction::ReduceWeight,

                'reason' => 'Needs review',
            ];
        }

        /*
         |----------------------------------------------------------
         | High Dependency
         |----------------------------------------------------------
         */

        if (
            $quality->singleKeywordPercentage >= 90
            &&
            $quality->matchCount <= 5
        ) {

            return [

                'action' => KeywordCandidateAction::ReduceWeight,

                'reason' => 'High single-keyword dependency',
            ];
        }

        return [

            'action' => KeywordCandidateAction::Keep,

            'reason' => 'Healthy keyword',
        ];
    }
}
