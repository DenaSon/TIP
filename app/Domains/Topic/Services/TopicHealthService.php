<?php

namespace Domains\Topic\Services;

use Domains\Topic\Data\TopicHealthData;
use Domains\Topic\Data\TopicMetricsData;
use Domains\Topic\Enums\TopicHealth;

readonly class TopicHealthService
{
    public function calculate(
        TopicMetricsData $metrics
    ): TopicHealthData {

        $health = TopicHealth::Poor;

        if (
            $metrics->growthRate >= 25
            &&
            $metrics->momentum >= 20
            &&
            $metrics->opportunityScore >= 50
        ) {

            $health =
                TopicHealth::Excellent;

        } elseif (

            $metrics->growthRate >= 10
            &&
            $metrics->momentum >= 10
            &&
            $metrics->opportunityScore >= 30

        ) {

            $health =
                TopicHealth::Good;

        } elseif (

            $metrics->growthRate >= 0
            &&
            $metrics->opportunityScore >= 10

        ) {

            $health =
                TopicHealth::Fair;
        }

        return new TopicHealthData(

            health: $health,

            growthRate: $metrics->growthRate,

            momentum: $metrics->momentum,

            opportunityScore: $metrics->opportunityScore,
        );
    }
}
