<?php

namespace Domains\Trend\Actions;

use Domains\Topic\Models\Topic;
use Domains\Trend\Models\Trend;
use Domains\Trend\Services\TrendScoreService;

readonly class CalculateTrendAction
{
    public function __construct(
        private TrendScoreService $service
    ) {}

    public function execute(
        Topic $topic
    ): void {

        $growthRate =
            $this->service
                ->calculateGrowth($topic);

        $authorityScore =
            $this->service
                ->calculateAuthority($topic);

        $score = $this->calculateScore(
            growthRate: $growthRate,
            authorityScore: $authorityScore
        );

        Trend::query()
            ->updateOrCreate(
                [
                    'topic_id' => $topic->id,
                ],
                [
                    'growth_rate' => $growthRate,

                    'authority_score' => $authorityScore,

                    'score' => $score,

                    'calculated_at' => now(),
                ]
            );
    }

    private function calculateScore(
        float $growthRate,
        float $authorityScore
    ): float {

        return round(
            $growthRate +
            ($authorityScore * 0.5),
            2
        );
    }
}
