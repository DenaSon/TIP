<?php

namespace Domains\Topic\Data;

readonly class KeywordVariantData
{
    /**
     * @param  array<string>  $variants
     */
    public function __construct(

        public string $keyword,

        public array $variants,
    ) {}
}
