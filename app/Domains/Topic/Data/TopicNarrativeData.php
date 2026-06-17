<?php

namespace Domains\Topic\Data;

readonly class TopicNarrativeData
{
    /**
     * @param  string[]  $insights
     */
    public function __construct(
        public string $summary,

        public array $insights,
    ) {}

    public function toArray(): array
    {
        return [

            'summary' => $this->summary,

            'insights' => $this->insights,
        ];
    }
}
