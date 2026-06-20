<?php

namespace Domains\Topic\Services;

use Domains\Topic\Data\TopicAuditData;
use Domains\Topic\Models\Topic;

readonly class TopicAuditService
{
    public function __construct(
        private TopicQualityService $qualityService,
        private TopicBoundaryAnalysisService $boundaryService,
    ) {}

    public function analyze(
        Topic $topic
    ): TopicAuditData {

        $quality =
            $this->qualityService
                ->analyze($topic);

        $boundary =
            $this->boundaryService
                ->analyze($topic);

        return new TopicAuditData(

            topicName: $topic->name,

            coverage: $quality->coverage,

            sourceDiversity: $quality->sourceDiversity,

            overlapPercentage: $quality->overlapPercentage,

            boundaryScore: $boundary->boundaryScore,

            boundaryStatus: $boundary->boundaryStatus,

            highestOverlapTopic: $boundary->highestOverlapTopic,

            highestOverlapPercentage: $boundary->highestOverlapPercentage,

            requiresReview: $boundary->requiresReview,
        );
    }
}
