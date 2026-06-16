<?php

namespace Domains\Topic\Actions;

use Domains\Content\Models\Content;
use Domains\Topic\Models\ContentTopicMatch;
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
            ->sync($topicIds);

        ContentTopicMatch::query()
            ->where(
                'content_id',
                $content->id
            )
            ->delete();

        foreach ($matches as $match) {

            ContentTopicMatch::updateOrCreate(
                [
                    'content_id' => $content->id,
                    'topic_id' => $match['topic_id'],
                ],
                [
                    'score' => $match['score'],
                    'matched_keywords' => $match['matched_keywords'],
                ]
            );
        }

    }
}
