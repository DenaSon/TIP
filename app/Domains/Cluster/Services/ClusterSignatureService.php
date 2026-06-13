<?php

namespace Domains\Cluster\Services;



use App\Domains\Topic\Services\TextNormalizer;

readonly class ClusterSignatureService
{
    public function __construct(
        private TextNormalizer $normalizer,
    ) {}

    public function generate(string $title): string
    {
        $title = strip_tags($title);

        $title = $this->normalizer->normalize($title);

        $title = mb_strtolower($title);

        $words = preg_split(
            '/\s+/u',
            $title,
            -1,
            PREG_SPLIT_NO_EMPTY
        );

        $words = array_filter(
            $words,
            fn ($word) => mb_strlen($word) >= 3
        );

        $words = array_slice(
            array_values($words),
            0,
            3
        );

        return implode(' ', $words);
    }
}
