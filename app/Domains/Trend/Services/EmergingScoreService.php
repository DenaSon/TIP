<?php

namespace Domains\Trend\Services;

use Domains\Topic\Models\Topic;
use Domains\Trend\Models\Trend;

readonly class EmergingScoreService
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

        $sizePenalty = min(
            $topic->contents()->count() / 200,
            5
        );

        return round(
            $trend->growth_rate
            + $momentum
            - $sizePenalty,
            2
        );
    }
}
