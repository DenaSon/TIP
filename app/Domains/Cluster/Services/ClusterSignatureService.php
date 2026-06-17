<?php

namespace Domains\Cluster\Services;

use App\Domains\Topic\Services\TextNormalizer;

readonly class ClusterSignatureService
{
    private const SIGNATURE_WORD_LIMIT = 5;

    private const STOP_WORDS = [

        'the',
        'a',
        'an',
        'and',
        'or',
        'for',
        'with',
        'from',
        'into',
        'onto',
        'of',
        'to',
        'in',
        'on',
        'at',
        'is',
        'are',
        'was',
        'were',
        'be',
        'been',
        'being',
        'by',
        'about',
        'after',
        'before',
        'over',
        'under',
        'through',
        'new',
        'how',
        'why',
        'what',
        'when',
        'where',
        'who',
        'your',
        'their',
        'our',
        'his',
        'her',
        'its',
        'this',
        'that',
        'these',
        'those',
        'now',
        'today',
        'latest',
        'introducing',
        'introduce',
        'announcement',
        'announcing',
        'welcome',
        'meet',
    ];

    private const SYNONYMS = [

        // launch
        'launches' => 'launch',
        'launched' => 'launch',
        'launching' => 'launch',

        // release
        'releases' => 'release',
        'released' => 'release',
        'releasing' => 'release',

        // introduce
        'introduces' => 'introduce',
        'introduced' => 'introduce',
        'introducing' => 'introduce',

        // announce
        'announces' => 'announce',
        'announced' => 'announce',
        'announcing' => 'announce',

        // singularization
        'models' => 'model',
        'agents' => 'agent',
        'systems' => 'system',
        'frameworks' => 'framework',
        'tools' => 'tool',
        'applications' => 'application',
        'platforms' => 'platform',
        'benchmarks' => 'benchmark',
        'datasets' => 'dataset',
        'embeddings' => 'embedding',

        // AI ecosystem
        'llms' => 'llm',
        'gpts' => 'gpt',
    ];

    public function __construct(
        private TextNormalizer $normalizer,
    ) {}

    public function generate(string $title): string
    {
        $title = $this->normalizeTitle(
            $title
        );

        $words = $this->extractWords(
            $title
        );

        $words = $this->normalizeWords(
            $words
        );

        $words = $this->filterWords(
            $words
        );

        $words = array_unique(
            $words
        );

        sort($words);

        $words = array_slice(
            $words,
            0,
            self::SIGNATURE_WORD_LIMIT
        );

        if (empty($words)) {
            return 'unknown';
        }

        return implode(
            ' ',
            $words
        );
    }

    private function normalizeTitle(
        string $title
    ): string {

        $title = strip_tags(
            $title
        );

        $title = $this->normalizer
            ->normalize($title);

        $title = mb_strtolower(
            $title
        );

        $title = preg_replace(
            '/[^\p{L}\p{N}\s\-]/u',
            ' ',
            $title
        );

        return trim(
            $title
        );
    }

    private function extractWords(
        string $title
    ): array {

        return preg_split(
            '/\s+/u',
            $title,
            -1,
            PREG_SPLIT_NO_EMPTY
        );
    }

    private function normalizeWords(
        array $words
    ): array {

        return array_map(
            fn (string $word) => self::SYNONYMS[$word] ?? $word,
            $words
        );
    }

    private function filterWords(
        array $words
    ): array {

        return array_values(
            array_filter(
                $words,
                function (string $word): bool {

                    if (
                        mb_strlen($word) < 3
                    ) {
                        return false;
                    }

                    if (
                        in_array(
                            $word,
                            self::STOP_WORDS,
                            true
                        )
                    ) {
                        return false;
                    }

                    return true;
                }
            )
        );
    }
}
