<?php

namespace Domains\Topic\Services;

use Domains\Topic\Models\Topic;

class TopicSourceDiversityService
{
    public function calculate(
        Topic $topic
    ): int {

        return $topic
            ->contents()
            ->distinct('source_id')
            ->count('source_id');
    }
}
