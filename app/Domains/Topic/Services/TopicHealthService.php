<?php

namespace Domains\Topic\Services;

use Domains\Opportunity\Services\OpportunityScoreService;
use Domains\Topic\Data\TopicHealthData;
use Domains\Topic\Enums\TopicHealth;
use Domains\Trend\Models\Trend;
use Domains\Trend\Services\MomentumService;

readonly class TopicHealthService
{
    public function __construct(
        private MomentumService $momentumService,
        private OpportunityScoreService $opportunityScoreService,
    ) {}

    public function calculate(
        Trend $trend
    ): TopicHealthData {

        $momentum =
            $this->momentumService
                ->calculate(
                    $trend->growth_rate,
                    $trend->velocity
                );

        $opportunity =
            $this->opportunityScoreService
                ->calculate($trend);

        $health = TopicHealth::Poor;

        if (
            $trend->growth_rate >= 25
            &&
            $momentum >= 20
            &&
            $opportunity >= 50
        ) {
            $health = TopicHealth::Excellent;
        } elseif (
            $trend->growth_rate >= 10
            &&
            $momentum >= 10
            &&
            $opportunity >= 30
        ) {
            $health = TopicHealth::Good;
        } elseif (
            $trend->growth_rate >= 0
            &&
            $opportunity >= 10
        ) {
            $health = TopicHealth::Fair;
        }

        return new TopicHealthData(
            health: $health,
            growthRate: $trend->growth_rate,
            momentum: $momentum,
            opportunityScore: $opportunity,
        );
    }
}
