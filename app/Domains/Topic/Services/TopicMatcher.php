<?php

namespace Domains\Topic\Services;

use App\Domains\Topic\Repositories\TopicKeywordRepository;
use App\Domains\Topic\Services\TextNormalizer;

readonly class TopicMatcher
{
    public function __construct(
        private TopicKeywordRepository $repository,
        private TextNormalizer $normalizer,
    ) {}

    public function match(string $text): array
    {
        $text = $this->normalizer->normalize($text);

        $topics = $this->repository->all();

        $results = [];

        foreach ($topics as $topic) {

            $score = 0;

            $matchedKeywords = [];

            foreach ($topic->keywords as $keyword) {

                $keywordText =
                    $this->normalizer->normalize(
                        $keyword->keyword
                    );

                if (
                    str_contains(
                        $text,
                        $keywordText
                    )
                ) {

                    $score +=
                        $keyword->weight;

                    $matchedKeywords[] = [

                        'keyword' => $keyword->keyword,

                        'weight' => $keyword->weight,
                    ];
                }
            }

            if (
                $score >=
                config(
                    'tip.topic_match_threshold',
                    5
                )
            ) {

                $results[] = [

                    'topic_id' => $topic->id,

                    'score' => $score,

                    'matched_keywords' => $matchedKeywords,
                ];
            }
        }

        usort(
            $results,
            fn ($a, $b) => $b['score']
                <=> $a['score']
        );

        return $results;
    }
}
