<?php

namespace Domains\Topic\Services;

class KeywordNormalizerService
{
    public function normalize(
        string $keyword
    ): string {

        $keyword =
            mb_strtolower(
                $keyword
            );

        $keyword =
            str_replace(
                [
                    '-',
                    '_',
                    '/',
                ],
                ' ',
                $keyword
            );

        $keyword =
            preg_replace(
                '/\s+/u',
                ' ',
                $keyword
            );

        return trim(
            $keyword
        );
    }
}
