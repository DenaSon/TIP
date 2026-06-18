<?php

namespace Domains\Topic\Data;

readonly class TopicDrillDownData
{
    public function __construct(
        public string $topic,
        public array $clusters,
    ) {}
}
