<?php

namespace Domains\Topic\Services;

use Domains\Content\Models\Content;
use Domains\Topic\Models\Topic;
use Domains\Topic\Support\TopicDictionary;

class TopicMatcher
{
    protected array $topics;

    public function __construct()
    {
        $this->topics = Topic::query()
            ->pluck('id', 'name')
            ->toArray();
    }

    public function match(
        Content $content
    ): array {

        $text = mb_strtolower(
            implode(' ', array_filter([
                $content->title,
                $content->excerpt,
                $content->content,
            ]))
        );

        $matched = [];

        foreach (
            TopicDictionary::all() as $topicName => $keywords
        ) {

            foreach ($keywords as $keyword) {

                if (
                    str_contains(
                        $text,
                        mb_strtolower($keyword)
                    )
                ) {

                    if (
                        isset(
                            $this->topics[$topicName]
                        )
                    ) {
                        $matched[] =
                            $this->topics[$topicName];
                    }

                    break;
                }
            }
        }

        return array_unique(
            $matched
        );
    }
}
