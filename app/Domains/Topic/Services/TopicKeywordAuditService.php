<?php

namespace Domains\Topic\Services;

use Domains\Topic\Data\TopicKeywordAuditData;
use Domains\Topic\Models\ContentTopicMatch;
use Domains\Topic\Models\Topic;

class TopicKeywordAuditService
{
    /**
     * @return TopicKeywordAuditData[]
     */
    public function analyze(
        Topic $topic
    ): array {

        $stats = [];

        foreach (
            $topic->keywords as $keyword
        ) {

            $stats[$keyword->keyword] = [

                'weight' => $keyword->weight,

                'matches' => 0,

                'single_matches' => 0,
            ];
        }

        ContentTopicMatch::query()
            ->where(
                'topic_id',
                $topic->id
            )
            ->select([
                'matched_keywords',
            ])
            ->chunk(
                1000,
                function (
                    $matches
                ) use (
                    &$stats
                ) {

                    foreach (
                        $matches as $match
                    ) {

                        $matchedKeywords =
                            $match->matched_keywords ?? [];

                        $keywordCount =
                            count(
                                $matchedKeywords
                            );

                        foreach (
                            $matchedKeywords as $item
                        ) {

                            $keyword =
                                $item['keyword']
                                ?? null;

                            if (
                                ! $keyword
                                || ! isset(
                                    $stats[$keyword]
                                )
                            ) {
                                continue;
                            }

                            $stats[$keyword]['matches']++;

                            if (
                                $keywordCount === 1
                            ) {

                                $stats[$keyword]['single_matches']++;
                            }
                        }
                    }
                }
            );

        $results = [];

        foreach (
            $topic->keywords as $keyword
        ) {

            $matchCount =
                $stats[
                $keyword->keyword
                ]['matches'];

            $singleKeywordMatchCount =
                $stats[
                $keyword->keyword
                ]['single_matches'];

            $singleKeywordPercentage =
                $matchCount === 0
                    ? 0
                    : round(
                    (
                        $singleKeywordMatchCount
                        / $matchCount
                    ) * 100,
                    2
                );

            $results[] =
                new TopicKeywordAuditData(

                    topicId:
                    $topic->id,

                    topicName:
                    $topic->name,

                    keyword:
                    $keyword->keyword,

                    weight:
                    $keyword->weight,

                    matchCount:
                    $matchCount,

                    singleKeywordMatchCount:
                    $singleKeywordMatchCount,

                    singleKeywordPercentage:
                    $singleKeywordPercentage,
                );
        }

        usort(
            $results,
            fn (
                TopicKeywordAuditData $a,
                TopicKeywordAuditData $b
            ) =>
                $b->singleKeywordPercentage
                <=>
                $a->singleKeywordPercentage
        );

        return $results;
    }
}
