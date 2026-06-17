<?php

namespace Domains\Trend\Services;

use Domains\Topic\Models\Topic;

class VelocityCalculator
{
    public function calculate(
        Topic $topic
    ): float {

        $snapshots = $topic
            ->snapshots()
            ->orderBy(
                'captured_at'
            )
            ->get();

        if (
            $snapshots->count() < 3
        ) {
            return 0;
        }

        $current =
            $snapshots[
            $snapshots->count() - 1
            ];

        $previous =
            $snapshots[
            $snapshots->count() - 2
            ];

        $older =
            $snapshots[
            $snapshots->count() - 3
            ];

        $currentGrowth =
            $this->growth(
                $previous->content_count,
                $current->content_count
            );

        $previousGrowth =
            $this->growth(
                $older->content_count,
                $previous->content_count
            );

        return round(
            $currentGrowth -
            $previousGrowth,
            2
        );
    }

    private function growth(
        int $old,
        int $new
    ): float {

        if ($old === 0) {
            return 0;
        }

        return (
            ($new - $old)
            / $old
        ) * 100;
    }
}
