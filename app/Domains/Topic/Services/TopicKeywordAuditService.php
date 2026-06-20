<?php

namespace Domains\Topic\Services;

use Domains\Topic\Data\TopicKeywordAuditData;
use Domains\Topic\Models\ContentTopicMatch;
use Domains\Topic\Models\Topic;

readonly class TopicKeywordAuditService
{
    public function __construct(
        private KeywordNormalizerService $normalizer,
    ) {}

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

            $normalizedKeyword =
                $this->normalizer
                    ->normalize(
                        $keyword->keyword
                    );

            $stats[$normalizedKeyword] = [

                'keyword' => $keyword->keyword,

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

                            if (! $keyword) {
                                continue;
                            }

                            $normalizedKeyword =
                                $this->normalizer
                                    ->normalize(
                                        $keyword
                                    );

                            if (
                                ! isset(
                                    $stats[
                                    $normalizedKeyword
                                    ]
                                )
                            ) {
                                continue;
                            }

                            $stats[
                            $normalizedKeyword
                            ]['matches']++;

                            if (
                                $keywordCount === 1
                            ) {

                                $stats[
                                $normalizedKeyword
                                ]['single_matches']++;
                            }
                        }
                    }
                }
            );

        $results = [];

        foreach (
            $stats as $stat
        ) {

            $matchCount =
                $stat['matches'];

            $singleKeywordMatchCount =
                $stat['single_matches'];

            $singleKeywordPercentage =
                $matchCount === 0
                    ? 0
                    : round(
                        (
                            $singleKeywordMatchCount
                            /
                            $matchCount
                        ) * 100,
                        2
                    );

            $results[] =
                new TopicKeywordAuditData(

                    topicId: $topic->id,

                    topicName: $topic->name,

                    keyword: $stat['keyword'],

                    weight: $stat['weight'],

                    matchCount: $matchCount,

                    singleKeywordMatchCount: $singleKeywordMatchCount,

                    singleKeywordPercentage: $singleKeywordPercentage,
                );
        }

        usort(
            $results,
            fn (
                TopicKeywordAuditData $a,
                TopicKeywordAuditData $b
            ) => $b->singleKeywordPercentage
                <=>
                $a->singleKeywordPercentage
        );

        return $results;
    }
}
