<?php

namespace Domains\Topic\Actions;

use Domains\Topic\Data\TopicDrillDownData;
use Domains\Topic\Models\Topic;

class GetTopicDrillDownAction
{
    public function execute(
        Topic $topic
    ): TopicDrillDownData {

        $clusters =
            $topic
                ->clusters()
                ->with([
                    'contents',
                ])
                ->orderByDesc(
                    'content_count'
                )
                ->get();

        return new TopicDrillDownData(
            topic: $topic->name,
            clusters: $clusters->all(),
        );
    }
}
