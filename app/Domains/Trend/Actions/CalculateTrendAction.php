<?php

namespace Domains\Trend\Actions;

use Domains\Topic\Models\Topic;
use Domains\Trend\Models\Trend;
use Domains\Trend\Services\TrendScoreService;

class CalculateTrendAction
{
    public function __construct(
        private readonly TrendScoreService $service
    ) {
    }

    public function execute(
        Topic $topic
    ): void {

        $growthRate =
            $this->service
                ->calculateGrowth($topic);

        $authorityScore =
            $this->service
                ->calculateAuthority($topic);

        $score =
            $growthRate +
            ($authorityScore * 0.5);

        Trend::updateOrCreate(
            [
                'topic_id' => $topic->id,
            ],
            [
                'growth_rate' => $growthRate,

                'authority_score' => $authorityScore,

                'score' => round(
                    $score,
                    2
                ),

                'calculated_at' => now(),
            ]
        );
    }
}
