<?php

namespace Domains\Opportunity\Services;

use Domains\Opportunity\Data\OpportunityBreakdownData;
use Domains\Trend\Models\Trend;
use Domains\Trend\Services\MomentumService;

readonly class OpportunityBreakdownService
{
    public function __construct(
        private MomentumService $momentumService,
    ) {}

    public function calculate(
        Trend $trend
    ): OpportunityBreakdownData {

        // Raw Values

        $trendScore =
            (float) $trend->score;

        $momentum =
            $this->momentumService
                ->calculate(
                    $trend->growth_rate,
                    $trend->velocity
                );

        $authorityScore =
            (float) $trend->authority_score;

        // Weighted Contributions

        $trendContribution =
            round(
                $trendScore * 0.4,
                2
            );

        $momentumContribution =
            round(
                $momentum * 0.5,
                2
            );

        $authorityContribution =
            round(
                $authorityScore * 0.1,
                2
            );

        // Final Score

        $opportunityScore =
            round(
                $trendContribution
                + $momentumContribution
                + $authorityContribution,
                2
            );

        return new OpportunityBreakdownData(
            trendScore: $trendScore,
            momentum: $momentum,
            authorityScore: $authorityScore,

            trendContribution: $trendContribution,
            momentumContribution: $momentumContribution,
            authorityContribution: $authorityContribution,

            opportunityScore: $opportunityScore,
        );
    }
}
