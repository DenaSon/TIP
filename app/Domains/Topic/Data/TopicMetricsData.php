<?php

namespace Domains\Topic\Data;

readonly class TopicMetricsData
{
    public function __construct(

        // Trend Metrics

        public float $growthRate,

        public float $velocity,

        public float $momentum,

        public float $authorityScore,

        public float $opportunityScore,

        // Topic Statistics

        public int $contentCount,

        public int $clusterCount,
    ) {}

    public function toArray(): array
    {
        return [

            'growth_rate' => $this->growthRate,

            'velocity' => $this->velocity,

            'momentum' => $this->momentum,

            'authority_score' => $this->authorityScore,

            'opportunity_score' => $this->opportunityScore,

            'content_count' => $this->contentCount,

            'cluster_count' => $this->clusterCount,
        ];
    }
}
