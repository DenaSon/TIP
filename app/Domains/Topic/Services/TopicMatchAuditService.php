<?php

namespace Domains\Topic\Services;

use Domains\Topic\Data\TopicAuditContextData;
use Domains\Topic\Data\TopicMatchAuditData;
use Domains\Topic\Models\ContentTopicMatch;

readonly class TopicMatchAuditService
{
    public function __construct(
        private TopicMatchConfidenceService $confidenceService,
    ) {}

    public function analyze(
        ContentTopicMatch $match,
        TopicAuditContextData $context,
    ): TopicMatchAuditData {

        $confidence =
            $this->confidenceService
                ->calculate(
                    match: $match,

                    topicMedianScore: $context->medianScore,

                    topicRequiresReview: $context->requiresReview,
                );

        return new TopicMatchAuditData(

            contentId: $match->content_id,

            topicId: $context->topicId,

            topicName: $context->topicName,

            score: $match->score,

            keywordCount: $confidence['keyword_count'],

            confidenceScore: $confidence['confidence_score'],

            requiresReview: $confidence['requires_review'],

            reasons: $confidence['reasons'],
        );
    }
}
