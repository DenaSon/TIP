<?php

namespace Domains\Opportunity\Services;

use Domains\Topic\Models\Topic;
use Domains\Trend\Models\Trend;
use Domains\Trend\Services\MomentumService;

class OpportunityScoreService
{
    public function __construct(
        private MomentumService $momentumService,
    ) {}

    public function calculate(
        Topic $topic,
        Trend $trend
    ): float {

        $momentum =
            $this->momentumService
                ->calculate(
                    $trend->growth_rate,
                    $trend->velocity
                );

        return round(

            ($trend->score * 0.4)

            +

            ($momentum * 0.5)

            +

            ($trend->authority_score * 0.1),

            2
        );
    }
}
