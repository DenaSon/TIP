<?php

namespace Domains\Opportunity\Services;

use Domains\Opportunity\Data\OpportunityDetailsData;
use Domains\Trend\Models\Trend;

readonly class OpportunityDetailsService
{
    public function __construct(
        private OpportunityBreakdownService $breakdownService,
        private OpportunityReasonService $reasonService,
        private OpportunityConfidenceService $confidenceService,
    ) {}

    public function build(
        Trend $trend
    ): OpportunityDetailsData {

        $breakdown =
            $this->breakdownService
                ->calculate($trend);

        $confidence =
            $this->confidenceService
                ->calculate($trend);

        $reasons =
            $this->reasonService
                ->generate($trend);

        return new OpportunityDetailsData(
            opportunityScore:
            $breakdown->opportunityScore,

            breakdown:
            $breakdown,

            confidence:
            $confidence,

            reasons:
            $reasons,
        );
    }
}
