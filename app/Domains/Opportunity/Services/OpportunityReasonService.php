<?php

namespace Domains\Opportunity\Services;

use Domains\Opportunity\Data\OpportunityReasonData;
use Domains\Opportunity\Enums\OpportunityReason;
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

            $reason =
                OpportunityReason::RapidGrowth;

            $reasons[] =
                new OpportunityReasonData(
                    code: $reason->value,
                    title: $reason->title(),
                    description: $reason->description(),
                );
        }

        if ($breakdown->momentumContribution >= 20) {

            $reason =
                OpportunityReason::PositiveMomentum;

            $reasons[] =
                new OpportunityReasonData(
                    code: $reason->value,
                    title: $reason->title(),
                    description: $reason->description(),
                );
        }

        if ($breakdown->authorityContribution >= 7) {

            $reason =
                OpportunityReason::StrongAuthority;

            $reasons[] =
                new OpportunityReasonData(
                    code: $reason->value,
                    title: $reason->title(),
                    description: $reason->description(),
                );
        }

        if ($breakdown->opportunityScore >= 80) {

            $reason =
                OpportunityReason::HighOpportunity;

            $reasons[] =
                new OpportunityReasonData(
                    code: $reason->value,
                    title: $reason->title(),
                    description: $reason->description(),
                );
        }

        if (empty($reasons)) {

            $reason =
                OpportunityReason::StableActivity;

            $reasons[] =
                new OpportunityReasonData(
                    code: $reason->value,
                    title: $reason->title(),
                    description: $reason->description(),
                );
        }

        return $reasons;
    }
}
