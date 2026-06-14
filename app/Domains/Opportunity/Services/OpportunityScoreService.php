<?php

namespace Domains\Opportunity\Services;

use Domains\Topic\Models\Topic;
use Domains\Trend\Models\Trend;

class OpportunityScoreService
{
    public function calculate(
        Topic $topic,
        Trend $trend
    ): float {

        $trendScore =
            (float) $trend->score;

        $contentBonus =
            min(
                $topic->contents()->count() * 0.5,
                50
            );

        $clusterBonus =
            min(
                $topic->clusters()->count() * 5,
                25
            );

        return round(
            $trendScore +
            $contentBonus +
            $clusterBonus,
            2
        );
    }
}
