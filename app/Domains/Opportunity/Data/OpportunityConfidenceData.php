<?php

namespace Domains\Opportunity\Data;

readonly class OpportunityConfidenceData
{
    public function __construct(
        public float $score,
        public int $snapshotCount,
    ) {}

    public function toArray(): array
    {
        return [
            'score' => $this->score,
            'snapshot_count' => $this->snapshotCount,
        ];
    }
}
