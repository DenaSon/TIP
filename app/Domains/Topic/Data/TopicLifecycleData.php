<?php

namespace Domains\Topic\Data;

use Domains\Topic\Enums\TopicLifecycle;

readonly class TopicLifecycleData
{
    public function __construct(
        public TopicLifecycle $lifecycle,

        public float $growthRate,

        public float $momentum,

        public float $opportunityScore,
    ) {}

    public function toArray(): array
    {
        return [

            'lifecycle' => $this->lifecycle->value,

            'growth_rate' => $this->growthRate,

            'momentum' => $this->momentum,

            'opportunity_score' => $this->opportunityScore,
        ];
    }
}
