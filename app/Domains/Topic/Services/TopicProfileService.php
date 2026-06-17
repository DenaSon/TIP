<?php

namespace Domains\Topic\Services;

use Domains\Topic\Data\TopicProfileData;
use Domains\Trend\Models\Trend;
use Domains\Trend\Services\MomentumService;

readonly class TopicProfileService
{
    public function __construct(
        private TopicHealthService $healthService,
        private TopicLifecycleService $lifecycleService,
        private MomentumService $momentumService,
        private StrategicSignalService $signalService,
        private TopicNarrativeService $narrativeService,
    ) {}

    public function build(
        Trend $trend
    ): TopicProfileData {

        $topic =
            $trend->topic;

        $contentCount =
            $topic
                ->contents()
                ->count();

        $clusterCount =
            $topic
                ->clusters()
                ->count();

        $momentum =
            $this->momentumService
                ->calculate(
                    $trend->growth_rate,
                    $trend->velocity
                );

        $signals =
            $this->signalService
                ->generate($trend);

        $narrative =
            $this->narrativeService
                ->generate($trend);

        return new TopicProfileData(

            topic: $topic->name,

            growthRate: $trend->growth_rate,

            velocity: $trend->velocity,

            momentum: $momentum,

            authorityScore: $trend->authority_score,

            contentCount: $contentCount,

            clusterCount: $clusterCount,

            health: $this->healthService
                ->calculate($trend),

            lifecycle: $this->lifecycleService
                ->calculate($trend),

            signals: $signals,

            narrative: $narrative,
        );
    }
}
