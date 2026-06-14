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

        if ($trend->growth_rate > 50) {
            $reasons[] =
                'High growth rate detected';
        }

        if ($trend->authority_score > 50) {
            $reasons[] =
                'Strong source authority';
        }

        if (
            $topic->contents()->count() > 10
        ) {
            $reasons[] =
                'High content activity';
        }

        return implode(
            ', ',
            $reasons
        );
    }
}
