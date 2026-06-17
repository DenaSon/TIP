<?php

namespace Domains\Opportunity\Services;

use Domains\Opportunity\Data\OpportunityConfidenceData;
use Domains\Trend\Models\Trend;

readonly class OpportunityConfidenceService
{
    public function calculate(
        Trend $trend
    ): OpportunityConfidenceData {

        $snapshotCount =
            $trend
                ->topic
                ->snapshots()
                ->count();

        $score =
            round(
                min(
                    $snapshotCount / 10,
                    1
                ) * 100,
                2
            );

        return new OpportunityConfidenceData(
            score: $score,
            snapshotCount: $snapshotCount,
        );
    }
}
