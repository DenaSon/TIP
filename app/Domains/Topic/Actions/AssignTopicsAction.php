<?php

namespace Domains\Topic\Actions;

use Domains\Content\Models\Content;
use Domains\Topic\Services\TopicMatcher;

class AssignTopicsAction
{
    public function __construct(
        protected TopicMatcher $topicMatcher,
    ) {}

    public function execute(
        Content $content
    ): void {

        $topicIds = $this->topicMatcher
            ->match($content);

        if (empty($topicIds)) {
            return;
        }

        $content->topics()
            ->syncWithoutDetaching(
                $topicIds
            );
    }
}
