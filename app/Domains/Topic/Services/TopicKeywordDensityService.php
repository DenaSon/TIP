<?php

namespace Domains\Topic\Services;

use Domains\Topic\Models\ContentTopicMatch;
use Domains\Topic\Models\Topic;

class TopicKeywordDensityService
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

        if ($matches->isEmpty()) {
            return 0;
        }

        $average = $matches->avg(
            fn ($keywords) => count($keywords ?? [])
        );

        return round(
            $average,
            2
        );
    }
}
