<?php

namespace Domains\Opportunity\Services;

use Domains\Topic\Models\Topic;
use Domains\Trend\Models\Trend;

class OpportunityReasonService
{
    public function generate(
        Topic $topic,
        Trend $trend
    ): string {

        $reasons = [];

        if ($trend->growth_rate > 20) {

            $reasons[] =
                'Growing topic activity';
        }

        if ($trend->velocity > 0) {

            $reasons[] =
                'Positive growth velocity';
        }

        if ($trend->authority_score > 80) {

            $reasons[] =
                'Trusted source coverage';
        }

        return empty($reasons)
            ? 'Stable topic activity'
            : implode(', ', $reasons);
    }
}
