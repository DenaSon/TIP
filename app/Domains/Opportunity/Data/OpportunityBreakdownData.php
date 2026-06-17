<?php

namespace Domains\Opportunity\Data;

readonly class OpportunityBreakdownData
{
    public function __construct(

        // Raw Values
        public float $trendScore,
        public float $momentum,
        public float $authorityScore,

        // Weighted Contributions
        public float $trendContribution,
        public float $momentumContribution,
        public float $authorityContribution,

        // Final Score
        public float $opportunityScore,
    ) {}

    public function toArray(): array
    {
        return [

            'trend_score' => $this->trendScore,
            'momentum' => $this->momentum,
            'authority_score' => $this->authorityScore,

            'trend_contribution' => $this->trendContribution,
            'momentum_contribution' => $this->momentumContribution,
            'authority_contribution' => $this->authorityContribution,

            'opportunity_score' => $this->opportunityScore,
        ];
    }
}
