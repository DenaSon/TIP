<?php

namespace Domains\Opportunity\Data;

readonly class OpportunityDetailsData
{
    /**
     * @param OpportunityReasonData[] $reasons
     */
    public function __construct(
        public float $opportunityScore,

        public OpportunityBreakdownData $breakdown,

        public OpportunityConfidenceData $confidence,

        public array $reasons,
    ) {}

    public function toArray(): array
    {
        return [

            'opportunity_score' => $this->opportunityScore,

            'breakdown' =>
                $this->breakdown->toArray(),

            'confidence' =>
                $this->confidence->toArray(),

            'reasons' => array_map(
                fn (OpportunityReasonData $reason)
                => $reason->toArray(),
                $this->reasons
            ),
        ];
    }
}
