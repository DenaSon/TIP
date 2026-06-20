<?php

namespace App\Domains\Topic\Services;

use Domains\Topic\Models\ContentTopicMatch;
use Domains\Topic\Models\Topic;

class TopicOverlapService
{
    public function calculate(
        Topic $topic
    ): float {

        $contentIds =
            ContentTopicMatch::query()
                ->where(
                    'topic_id',
                    $topic->id
                )
                ->pluck('content_id');

        $total =
            $contentIds->count();

        if ($total === 0) {
            return 0;
        }

        $overlapping =
            ContentTopicMatch::query()
                ->select('content_id')
                ->whereIn(
                    'content_id',
                    $contentIds
                )
                ->groupBy('content_id')
                ->havingRaw('COUNT(*) > 1')
                ->get()
                ->count();

        return round(
            ($overlapping / $total) * 100,
            2
        );
    }
}
