<?php

namespace Domains\Opportunity\Services;

use Domains\Trend\Models\Trend;

readonly class OpportunityScoreService
{
    public function __construct(
        private OpportunityBreakdownService $breakdownService,
    ) {}

    public function calculate(
        Trend $trend
    ): float {

        return $this
            ->breakdownService
            ->calculate($trend)
            ->opportunityScore;
    }
}
