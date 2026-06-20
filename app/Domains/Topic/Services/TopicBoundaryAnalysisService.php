<?php

namespace Domains\Topic\Services;

use Domains\Topic\Data\TopicBoundaryData;
use Domains\Topic\Models\Topic;

class TopicBoundaryAnalysisService
{
    public function __construct(
        private TopicOverlapMatrixService $overlapService,
    ) {}

    public function analyze(
        Topic $topic
    ): TopicBoundaryData {

        $overlaps =
            $this->overlapService
                ->analyze($topic);

        if (empty($overlaps)) {

            return new TopicBoundaryData(
                topicId: $topic->id,
                topicName: $topic->name,

                boundaryScore: 100,

                boundaryStatus: 'Healthy',

                highestOverlapTopic: null,

                highestOverlapPercentage: 0,
            );
        }

        $highest =
            collect($overlaps)
                ->sortByDesc(
                    fn ($item) => $item->overlapPercentage
                )
                ->first();

        $score =
            max(
                0,
                100 - $highest->overlapPercentage
            );

        return new TopicBoundaryData(

            topicId: $topic->id,

            topicName: $topic->name,

            boundaryScore: round($score, 2),

            boundaryStatus: $this->determineStatus(
                $highest->overlapPercentage
            ),

            highestOverlapTopic: $highest->overlappingTopicName,

            highestOverlapPercentage: $highest->overlapPercentage,
        );
    }

    private function determineStatus(
        float $overlap
    ): string {

        return match (true) {

            $overlap >= 50 => 'High Risk',

            $overlap >= 30 => 'Needs Review',

            default => 'Healthy',
        };
    }
}
