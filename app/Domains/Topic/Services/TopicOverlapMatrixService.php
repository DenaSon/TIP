<?php

namespace Domains\Topic\Services;

use Domains\Topic\Data\TopicOverlapData;
use Domains\Topic\Models\ContentTopicMatch;
use Domains\Topic\Models\Topic;

class TopicOverlapMatrixService
{
    /**
     * @return array<TopicOverlapData>
     */
    public function analyze(
        Topic $topic
    ): array {

        $contentIds =
            ContentTopicMatch::query()
                ->where(
                    'topic_id',
                    $topic->id
                )
                ->pluck('content_id');

        $coverage =
            $contentIds->count();

        if ($coverage === 0) {
            return [];
        }

        $overlaps =
            ContentTopicMatch::query()
                ->selectRaw('
                    topic_id,
                    COUNT(DISTINCT content_id) as shared_contents
                ')
                ->whereIn(
                    'content_id',
                    $contentIds
                )
                ->where(
                    'topic_id',
                    '!=',
                    $topic->id
                )
                ->groupBy('topic_id')
                ->orderByDesc('shared_contents')
                ->get();

        $topicNames =
            Topic::query()
                ->pluck(
                    'name',
                    'id'
                );

        return $overlaps
            ->map(
                function ($row) use (
                    $topic,
                    $coverage,
                    $topicNames
                ) {

                    return new TopicOverlapData(

                        topicId: $topic->id,

                        topicName: $topic->name,

                        overlappingTopicId: $row->topic_id,

                        overlappingTopicName: $topicNames[$row->topic_id]
                        ?? 'Unknown',

                        sharedContents: $row->shared_contents,

                        overlapPercentage: round(
                            (
                                $row->shared_contents
                                /
                                $coverage
                            ) * 100,
                            2
                        ),
                    );
                }
            )
            ->all();
    }
}
