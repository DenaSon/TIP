<?php

namespace Domains\Topic\Actions;

use Domains\Content\Models\Content;
use Domains\Topic\Models\Topic;

class RefreshTopicMatchesAction
{
    public function execute(
        Topic $topic
    ): int {

        $matched = 0;

        $topic->contents()->detach();

        $keywords = $topic
            ->keywords()
            ->pluck('keyword');

        Content::query()

            ->select([
                'id',
                'title',
                'excerpt',
                'content',
            ])

            ->chunkById(
                100,
                function ($contents) use (
                    $topic,
                    $keywords,
                    &$matched
                ) {

                    foreach ($contents as $content) {

                        $text = mb_strtolower(
                            strip_tags(
                                implode(
                                    ' ',
                                    [
                                        $content->title,
                                        $content->excerpt,
                                        $content->content,
                                    ]
                                )
                            )
                        );

                        foreach (
                            $keywords as $keyword
                        ) {

                            if (
                                str_contains(
                                    $text,
                                    mb_strtolower(
                                        $keyword
                                    )
                                )
                            ) {

                                $topic
                                    ->contents()
                                    ->syncWithoutDetaching([
                                        $content->id,
                                    ]);

                                $matched++;

                                break;
                            }
                        }
                    }
                }
            );

        return $matched;
    }
}
