<?php

namespace Domains\Topic\Services;

use Domains\Topic\Data\TopicProfileData;
use Domains\Trend\Models\Trend;

readonly class TopicProfileService
{
    public function __construct(
        private TopicMetricsService $metricsService,
        private TopicHealthService $healthService,
        private TopicLifecycleService $lifecycleService,
        private StrategicSignalService $signalService,
        private TopicNarrativeService $narrativeService,
    ) {}

    public function build(
        Trend $trend
    ): TopicProfileData {

        $topic =
            $trend->topic;

        $metrics =
            $this->metricsService
                ->build($trend);

        $signals =
            $this->signalService
                ->generate($metrics);

        $narrative =
            $this->narrativeService
                ->generate($metrics);

        return new TopicProfileData(

            topic: $topic->name,

            growthRate: $metrics->growthRate,

            velocity: $metrics->velocity,

            momentum: $metrics->momentum,

            authorityScore: $metrics->authorityScore,

            opportunityScore: $metrics->opportunityScore,

            contentCount: $metrics->contentCount,

            clusterCount: $metrics->clusterCount,

            health: $this->healthService
                ->calculate($metrics),

            lifecycle: $this->lifecycleService
                ->calculate($metrics),

            signals: $signals,

            narrative: $narrative,
        );
    }
}
