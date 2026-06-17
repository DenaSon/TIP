<?php

namespace Domains\Opportunity\Services;

use Domains\Opportunity\Data\OpportunityReasonData;
use Domains\Trend\Models\Trend;

readonly class OpportunityReasonService
{
    public function __construct(
        private OpportunityBreakdownService $breakdownService,
    ) {}

    /**
     * @return OpportunityReasonData[]
     */
    public function generate(
        Trend $trend
    ): array {

        $reasons = [];

        $breakdown =
            $this->breakdownService
                ->calculate($trend);

        if ($breakdown->trendContribution >= 30) {

            $reasons[] =
                new OpportunityReasonData(
                    code: 'rapid_growth',
                    title: 'Rapid Growth',
                    description:
                    'High trend contribution detected'
                );
        }

        if ($breakdown->momentumContribution >= 20) {

            $reasons[] =
                new OpportunityReasonData(
                    code: 'positive_momentum',
                    title: 'Positive Momentum',
                    description:
                    'Strong momentum contribution detected'
                );
        }

        if ($breakdown->authorityContribution >= 7) {

            $reasons[] =
                new OpportunityReasonData(
                    code: 'strong_authority',
                    title: 'Strong Source Coverage',
                    description:
                    'Trusted sources are covering this topic'
                );
        }

        if ($breakdown->opportunityScore >= 80) {

            $reasons[] =
                new OpportunityReasonData(
                    code: 'high_opportunity',
                    title: 'High Opportunity Score',
                    description:
                    'Overall opportunity score is exceptionally high'
                );
        }

        if (empty($reasons)) {

            $reasons[] =
                new OpportunityReasonData(
                    code: 'stable_activity',
                    title: 'Stable Activity',
                    description:
                    'No strong opportunity signals detected'
                );
        }

        return $reasons;
    }
}
