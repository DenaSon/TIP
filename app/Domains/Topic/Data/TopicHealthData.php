<?php

namespace Domains\Topic\Data;

use Domains\Topic\Enums\TopicHealth;

readonly class TopicHealthData
{
    public function __construct(
        public TopicHealth $health,

        public float $growthRate,

        public float $momentum,

        public float $opportunityScore,
    ) {}

    public function toArray(): array
    {
        return [

            'health' => $this->health->value,

            'growth_rate' => $this->growthRate,

            'momentum' => $this->momentum,

            'opportunity_score' => $this->opportunityScore,
        ];
    }
}
