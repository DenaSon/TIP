<?php

namespace Domains\Topic\Services;

use Domains\Topic\Models\Topic;

class TopicCoverageService
{
    public function calculate(
        Topic $topic
    ): int {
        return $topic
            ->contents()
            ->count();
    }
}
