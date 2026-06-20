<?php

namespace Domains\Topic\Services;

use Domains\Topic\Models\ContentTopicMatch;
use Domains\Topic\Models\Topic;

class TopicMatchStrengthService
{
    public function averageScore(
        Topic $topic
    ): float {

        return round(
            ContentTopicMatch::query()
                ->where(
                    'topic_id',
                    $topic->id
                )
                ->avg('score') ?? 0,
            2
        );
    }

    public function medianScore(
        Topic $topic
    ): float {

        $scores =
            ContentTopicMatch::query()
                ->where(
                    'topic_id',
                    $topic->id
                )
                ->orderBy('score')
                ->pluck('score')
                ->values();

        $count = $scores->count();

        if ($count === 0) {
            return 0;
        }

        $middle = intdiv(
            $count,
            2
        );

        if ($count % 2 === 0) {

            return round(
                (
                    $scores[$middle - 1]
                    +
                    $scores[$middle]
                ) / 2,
                2
            );
        }

        return round(
            $scores[$middle],
            2
        );
    }
}
