<?php

namespace Domains\Trend\Actions;

use Domains\Topic\Models\Topic;
use Domains\Trend\Models\Trend;
use Domains\Trend\Services\AccelerationCalculator;
use Domains\Trend\Services\TrendScoreService;
use Domains\Trend\Services\VelocityCalculator;

readonly class CalculateTrendAction
{
    public function __construct(
        private TrendScoreService $service,

        private VelocityCalculator $velocityCalculator,

        private AccelerationCalculator $accelerationCalculator,
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

        $velocity =
            $this->velocityCalculator
                ->calculate($topic);

        $acceleration =
            $this->accelerationCalculator
                ->calculate($topic);

        Trend::query()
            ->updateOrCreate(
                [
                    'topic_id' => $topic->id,
                ],
                [
                    'growth_rate' => $growthRate,

                    'velocity' => $velocity,

                    'acceleration' => $acceleration,

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
