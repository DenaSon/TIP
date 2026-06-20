<?php

namespace Domains\Topic\Services;

use Domains\Topic\Models\ContentTopicMatch;

class TopicMatchConfidenceService
{
    public function calculate(
        ContentTopicMatch $match,
        float $topicMedianScore,
        bool $topicRequiresReview,
    ): array {

        $confidence = 100;

        $reasons = [];

        $keywordCount =
            count(
                $match->matched_keywords ?? []
            );

        if ($keywordCount === 1) {

            $confidence -= 25;

            $reasons[] =
                'Single keyword match';
        }

        if (
            $match->score <
            $topicMedianScore
        ) {

            $confidence -= 25;

            $reasons[] =
                'Below topic median score';
        }

        if ($topicRequiresReview) {

            $confidence -= 25;

            $reasons[] =
                'Topic boundary under review';
        }

        return [

            'confidence_score' => max(
                0,
                $confidence
            ),

            'requires_review' => $confidence <= 50,

            'reasons' => $reasons,

            'keyword_count' => $keywordCount,
        ];
    }
}
