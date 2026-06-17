<?php

namespace Domains\Topic\Services;

use Domains\Topic\Data\TopicProfileData;
use Domains\Trend\Models\Trend;

readonly class TopicProfileService
{
    public function __construct(
        private TopicHealthService $healthService,
        private TopicLifecycleService $lifecycleService,
    ) {}

    public function build(
        Trend $trend
    ): TopicProfileData {

        return new TopicProfileData(

            topic: $trend->topic->name,

            health: $this->healthService
                ->calculate($trend),

            lifecycle: $this->lifecycleService
                ->calculate($trend),
        );
    }
}
