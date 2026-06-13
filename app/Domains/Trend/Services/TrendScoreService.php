<?php

namespace Domains\Trend\Services;

use Domains\Topic\Models\Topic;

class TrendScoreService
{
    public function calculateAuthority(
        Topic $topic
    ): float {
        return round(

            $topic->contents()

                ->join(
                    'sources',
                    'sources.id',
                    '=',
                    'contents.source_id'
                )

                ->avg(
                    'sources.authority_score'
                ) ?? 0,

            2
        );
    }

    public function calculateGrowth(
        Topic $topic
    ): float {

        $snapshots = $topic
            ->snapshots()
            ->orderByDesc('captured_at')
            ->orderByDesc('id')
            ->limit(2)
            ->get();

        if ($snapshots->count() < 2) {
            return 0;
        }

        $current = $snapshots[0];
        $previous = $snapshots[1];

        $newCount = $current->content_count;
        $oldCount = $previous->content_count;

        if ($oldCount === 0) {

            return $newCount > 0
                ? 100.0
                : 0.0;
        }

        return (
            ($newCount - $oldCount)
            / $oldCount
        ) * 100;
    }
}
