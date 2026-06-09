<?php

namespace App\Domains\Topic\Services;

class TextNormalizer
{
    public function normalize(string $text): string
    {
        $text = str_replace(
            ['ي', 'ك', 'ة'],
            ['ی', 'ک', 'ه'],
            $text
        );

        $text = str_replace('‌', ' ', $text);

        $text = preg_replace(
            '/[\x{064B}-\x{065F}]/u',
            '',
            $text
        );

        $text = preg_replace('/\s+/u', ' ', $text);

        return trim($text);
    }
}
