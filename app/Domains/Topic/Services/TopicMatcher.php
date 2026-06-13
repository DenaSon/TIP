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

        $scores = [];

        foreach ($topics as $topic) {

            $score = 0;

            foreach ($topic->keywords as $keyword) {

                $keywordText = $this->normalizer->normalize(
                    $keyword->keyword
                );

                if (str_contains($text, $keywordText)) {
                    $score += $keyword->weight;
                }
            }

            if ($score > 0) {
                $scores[] = [
                    'topic_id' => $topic->id,
                    'score' => $score,
                ];
            }
        }

        usort(
            $scores,
            fn ($a, $b) => $b['score'] <=> $a['score']
        );

        return $scores;
    }
}
