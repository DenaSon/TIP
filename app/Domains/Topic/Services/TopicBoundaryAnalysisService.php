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

        $overlaps = collect(
            $this->overlapService
                ->analyze($topic)
        )
            ->sortByDesc(
                fn ($item) => $item->overlapPercentage
            )
            ->values();

        if ($overlaps->isEmpty()) {

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
            $overlaps->first();

        $weights = [
            0 => 0.5,
            1 => 0.3,
            2 => 0.2,
        ];

        $risk = 0;

        foreach ($weights as $index => $weight) {

            $overlap =
                $overlaps->get($index);

            if (! $overlap) {
                continue;
            }

            $risk +=
                $overlap->overlapPercentage
                * $weight;
        }

        $boundaryScore =
            max(
                0,
                100 - $risk
            );

        return new TopicBoundaryData(

            topicId: $topic->id,

            topicName: $topic->name,

            boundaryScore: round(
                $boundaryScore,
                2
            ),

            boundaryStatus: $this->determineStatus(
                $risk
            ),

            highestOverlapTopic: $highest->overlappingTopicName,

            highestOverlapPercentage: $highest->overlapPercentage,
        );
    }

    private function determineStatus(
        float $risk
    ): string {

        return match (true) {

            $risk >= 40 => 'High Risk',

            $risk >= 20 => 'Needs Review',

            default => 'Healthy',
        };
    }
}
