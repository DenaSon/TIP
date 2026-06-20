<?php

namespace Domains\Topic\Services;

use App\Domains\Topic\Repositories\TopicKeywordRepository;
use App\Domains\Topic\Services\TextNormalizer;

readonly class TopicMatcher
{
    public function __construct(
        private TopicKeywordRepository $repository,
        private TextNormalizer $textNormalizer,
        private KeywordNormalizerService $keywordNormalizer,
        private KeywordVariantService $variantService,
    ) {}

    public function match(
        string $text
    ): array {

        $text =
            $this->textNormalizer
                ->normalize($text);

        $text =
            $this->keywordNormalizer
                ->normalize($text);

        $topics =
            $this->repository
                ->all();

        $results = [];

        foreach ($topics as $topic) {

            $score = 0;

            $matchedKeywords = [];

            foreach ($topic->keywords as $keyword) {

                $normalizedKeyword =
                    $this->keywordNormalizer
                        ->normalize(
                            $keyword->keyword
                        );

                $variants =
                    $this->variantService
                        ->generate(
                            $normalizedKeyword
                        )
                        ->variants;

                $matched = false;

                foreach (
                    $variants as $variant
                ) {

                    if (
                        ! str_contains(
                            $text,
                            $variant
                        )
                    ) {
                        continue;
                    }

                    $matched = true;

                    break;
                }

                if (! $matched) {
                    continue;
                }

                $score +=
                    $keyword->weight;

                $matchedKeywords[] = [

                    'keyword' => $keyword->keyword,

                    'weight' => $keyword->weight,
                ];
            }

            if (
                $score <
                config(
                    'tip.topic_match_threshold',
                    5
                )
            ) {
                continue;
            }

            $results[] = [

                'topic_id' => $topic->id,

                'score' => $score,

                'matched_keywords' => $matchedKeywords,
            ];
        }

        usort(
            $results,
            fn (
                array $a,
                array $b
            ) => $b['score']
                <=>
                $a['score']
        );

        return $results;
    }
}
