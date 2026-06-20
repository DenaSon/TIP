<?php

namespace Domains\Topic\Services;

use Domains\Topic\Data\KeywordVariantData;

class KeywordVariantService
{
    public function generate(
        string $keyword
    ): KeywordVariantData {

        $variants = [
            $keyword,
        ];

        $lastWord =
            str($keyword)
                ->afterLast(' ')
                ->toString();

        if (
            ! str_ends_with(
                $lastWord,
                's'
            )
        ) {

            $variants[] =
                preg_replace(
                    '/'.$lastWord.'$/',
                    $lastWord.'s',
                    $keyword
                );
        }

        return new KeywordVariantData(

            keyword: $keyword,

            variants: array_values(
                array_unique(
                    $variants
                )
            ),
        );
    }
}
