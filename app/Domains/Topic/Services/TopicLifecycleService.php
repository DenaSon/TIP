<?php

namespace Domains\Topic\Services;

use Domains\Topic\Data\TopicLifecycleData;
use Domains\Topic\Data\TopicMetricsData;
use Domains\Topic\Enums\TopicLifecycle;

readonly class TopicLifecycleService
{
    public function calculate(
        TopicMetricsData $metrics
    ): TopicLifecycleData {

        $lifecycle =
            TopicLifecycle::Stable;

        if (
            $metrics->growthRate >= 50
            &&
            $metrics->momentum >= 50
            &&
            $metrics->opportunityScore >= 50
        ) {

            $lifecycle =
                TopicLifecycle::Emerging;

        } elseif (

            $metrics->growthRate >= 10
            &&
            $metrics->momentum >= 10
            &&
            $metrics->opportunityScore >= 20

        ) {

            $lifecycle =
                TopicLifecycle::Growing;
        }

        return new TopicLifecycleData(

            lifecycle: $lifecycle,

            growthRate: $metrics->growthRate,

            momentum: $metrics->momentum,

            opportunityScore: $metrics->opportunityScore,
        );
    }
}
