<?php

namespace Domains\Topic\Actions;

use Domains\Content\Models\Content;
use Domains\Topic\Services\TopicMatcher;

class AssignTopicsAction
{
    public function __construct(
        protected TopicMatcher $topicMatcher,
    ) {}

    public function execute(Content $content): void
    {
        $text = implode(' ', [
            $content->title,
            $content->excerpt,
            $content->content,
        ]);

        $matches = $this->topicMatcher->match($text);

        if (empty($matches)) {
            return;
        }

        $topicIds = collect($matches)
            ->pluck('topic_id')
            ->all();

        $content->topics()
            ->syncWithoutDetaching($topicIds);
    }
}
