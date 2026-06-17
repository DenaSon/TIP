<?php

namespace Domains\Topic\Services;

use Domains\Opportunity\Services\OpportunityScoreService;
use Domains\Topic\Data\TopicLifecycleData;
use Domains\Topic\Enums\TopicLifecycle;
use Domains\Trend\Models\Trend;
use Domains\Trend\Services\MomentumService;

readonly class TopicLifecycleService
{
    public function __construct(
        private MomentumService $momentumService,
        private OpportunityScoreService $opportunityScoreService,
    ) {}

    public function calculate(
        Trend $trend
    ): TopicLifecycleData {

        $momentum =
            $this->momentumService
                ->calculate(
                    $trend->growth_rate,
                    $trend->velocity
                );

        $opportunity =
            $this->opportunityScoreService
                ->calculate($trend);

        $lifecycle =
            TopicLifecycle::Stable;

        if (
            $trend->growth_rate >= 50
            &&
            $momentum >= 50
            &&
            $opportunity >= 50
        ) {

            $lifecycle =
                TopicLifecycle::Emerging;
        } elseif (
            $trend->growth_rate >= 10
            &&
            $momentum >= 10
            &&
            $opportunity >= 20
        ) {

            $lifecycle =
                TopicLifecycle::Growing;
        }

        return new TopicLifecycleData(
            lifecycle: $lifecycle,

            growthRate: $trend->growth_rate,

            momentum: $momentum,

            opportunityScore: $opportunity,
        );
    }
}
