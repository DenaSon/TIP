<?php

namespace Domains\Topic\Services;

use Domains\Topic\Data\TopicKeywordQualityData;
use Domains\Topic\Enums\KeywordQualityGrade;
use Domains\Topic\Models\Topic;

readonly class TopicKeywordQualityService
{
    private const VOLUME_WEIGHT = 0.3;

    private const RELIABILITY_WEIGHT = 0.5;

    private const IMPORTANCE_WEIGHT = 0.2;

    public function __construct(
        private TopicKeywordAuditService $auditService,
    ) {}

    /**
     * @return TopicKeywordQualityData[]
     */
    public function analyze(
        Topic $topic
    ): array {

        $audits =
            $this->auditService
                ->analyze($topic);

        $results = [];

        foreach ($audits as $audit) {

            if ($audit->matchCount === 0) {

                $results[] =
                    new TopicKeywordQualityData(

                        topicId: $audit->topicId,

                        topicName: $audit->topicName,

                        keyword: $audit->keyword,

                        weight: $audit->weight,

                        matchCount: 0,

                        singleKeywordPercentage: 0,

                        qualityScore: 0,

                        qualityGrade: KeywordQualityGrade::NotValidated,
                    );

                continue;
            }

            $volumeScore =
                $this->calculateVolumeScore(
                    $audit->matchCount
                );

            $reliabilityScore =
                $this->calculateReliabilityScore(
                    $audit->singleKeywordPercentage
                );

            $importanceScore =
                $this->calculateImportanceScore(
                    $audit->weight
                );

            $qualityScore =
                round(
                    (
                        $volumeScore
                        * self::VOLUME_WEIGHT
                    )
                    +
                    (
                        $reliabilityScore
                        * self::RELIABILITY_WEIGHT
                    )
                    +
                    (
                        $importanceScore
                        * self::IMPORTANCE_WEIGHT
                    ),
                    2
                );

            $results[] =
                new TopicKeywordQualityData(

                    topicId: $audit->topicId,

                    topicName: $audit->topicName,

                    keyword: $audit->keyword,

                    weight: $audit->weight,

                    matchCount: $audit->matchCount,

                    singleKeywordPercentage: $audit->singleKeywordPercentage,

                    qualityScore: $qualityScore,

                    qualityGrade: $this->determineGrade(
                        $qualityScore
                    ),
                );
        }

        usort(
            $results,
            fn (
                TopicKeywordQualityData $a,
                TopicKeywordQualityData $b
            ) => $a->qualityScore
                <=>
                $b->qualityScore
        );

        return $results;
    }

    private function calculateVolumeScore(
        int $matches
    ): float {

        return min(
            100,
            round(
                log(
                    $matches + 1,
                    2
                ) * 15,
                2
            )
        );
    }

    private function calculateReliabilityScore(
        float $singleKeywordPercentage
    ): float {

        return max(
            0,
            round(
                100 - $singleKeywordPercentage,
                2
            )
        );
    }

    private function calculateImportanceScore(
        int $weight
    ): float {

        return min(
            100,
            max(
                0,
                $weight
            )
        );
    }

    private function determineGrade(
        float $qualityScore
    ): KeywordQualityGrade {

        return match (true) {

            $qualityScore >= 80 => KeywordQualityGrade::Excellent,

            $qualityScore >= 60 => KeywordQualityGrade::Good,

            $qualityScore >= 40 => KeywordQualityGrade::NeedsReview,

            default => KeywordQualityGrade::Weak,
        };
    }
}
