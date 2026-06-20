<?php

namespace Domains\Topic\Services;

use Domains\Topic\Data\TopicAuditContextData;
use Domains\Topic\Models\Topic;

readonly class TopicAuditContextService
{
    public function __construct(
        private TopicMatchStrengthService $strengthService,
        private TopicBoundaryAnalysisService $boundaryService,
    ) {}

    /**
     * @return array<int, TopicAuditContextData>
     */
    public function build(): array
    {
        $contexts = [];

        $topics = Topic::query()
            ->where(
                'is_active',
                true
            )
            ->get();

        foreach ($topics as $topic) {

            $boundary =
                $this->boundaryService
                    ->analyze(
                        $topic
                    );

            $contexts[$topic->id] =
                new TopicAuditContextData(

                    topicId: $topic->id,

                    topicName: $topic->name,

                    medianScore: $this->strengthService
                        ->medianScore(
                            $topic
                        ),

                    requiresReview: $boundary->requiresReview,
                );
        }

        return $contexts;
    }
}
