<?php


namespace Domains\Topic\Data;

readonly class TopicNarrativeData
{
    public function __construct(
        public string $summary,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'summary' => $this->summary,
        ];
    }
}
