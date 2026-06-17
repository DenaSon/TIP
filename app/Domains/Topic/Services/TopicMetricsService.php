<?php

namespace Domains\Topic\Services;

use Domains\Opportunity\Services\OpportunityScoreService;
use Domains\Topic\Data\TopicMetricsData;
use Domains\Trend\Models\Trend;
use Domains\Trend\Services\MomentumService;

readonly class TopicMetricsService
{
    public function __construct(
        private MomentumService $momentumService,
        private OpportunityScoreService $opportunityScoreService,
    ) {}

    public function build(
        Trend $trend
    ): TopicMetricsData {

        $topic =
            $trend->topic;

        $momentum =
            $this->momentumService
                ->calculate(
                    $trend->growth_rate,
                    $trend->velocity
                );

        $opportunityScore =
            $this->opportunityScoreService
                ->calculate($trend);

        $contentCount =
            $topic
                ->contents()
                ->count();

        $clusterCount =
            $topic
                ->clusters()
                ->count();

        return new TopicMetricsData(

            growthRate: $trend->growth_rate,

            velocity: $trend->velocity,

            momentum: $momentum,

            authorityScore: $trend->authority_score,

            opportunityScore: $opportunityScore,

            contentCount: $contentCount,

            clusterCount: $clusterCount,
        );
    }
}
