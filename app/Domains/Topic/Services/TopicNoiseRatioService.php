<?php

namespace Domains\Topic\Services;

use Domains\Topic\Models\ContentTopicMatch;
use Domains\Topic\Models\Topic;

class TopicNoiseRatioService
{
    public function calculate(
        Topic $topic
    ): float {

        $matches =
            ContentTopicMatch::query()
                ->where(
                    'topic_id',
                    $topic->id
                )
                ->pluck('matched_keywords');

        $total =
            $matches->count();

        if ($total === 0) {
            return 0;
        }

        $suspicious =
            $matches->filter(
                fn ($keywords) => count($keywords ?? []) === 1
            )->count();

        return round(
            ($suspicious / $total) * 100,
            2
        );
    }
}
