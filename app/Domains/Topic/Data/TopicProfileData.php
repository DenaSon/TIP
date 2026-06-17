<?php

namespace Domains\Topic\Data;
use Domains\Topic\Data\StrategicSignalData;
readonly class TopicProfileData
{
    /**
     * @param StrategicSignalData[] $signals
     */
    public function __construct(

        public string $topic,

        // Core Metrics
        public float $growthRate,

        public float $velocity,

        public float $momentum,

        public float $authorityScore,

        // Topic Statistics
        public int $contentCount,

        public int $clusterCount,

        // Intelligence
        public TopicHealthData $health,

        public TopicLifecycleData $lifecycle,

        public array $signals,

    ) {}

    public function toArray(): array
    {
        return [

            'topic' => $this->topic,

            'growth_rate' => $this->growthRate,

            'velocity' => $this->velocity,

            'momentum' => $this->momentum,

            'authority_score' => $this->authorityScore,

            'content_count' => $this->contentCount,

            'cluster_count' => $this->clusterCount,

            'health' => $this->health->toArray(),

            'lifecycle' => $this->lifecycle->toArray(),

            'signals' => array_map(
                fn (StrategicSignalData $signal)
                => $signal->toArray(),
                $this->signals
            ),
        ];
    }
}
