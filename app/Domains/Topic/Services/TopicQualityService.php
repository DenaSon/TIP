<?php

namespace Domains\Topic\Services;

use App\Domains\Topic\Services\TopicOverlapService;
use Domains\Topic\Data\TopicQualityData;
use Domains\Topic\Models\Topic;

readonly class TopicQualityService
{
    public function __construct(
        private TopicCoverageService $coverageService,
        private TopicOverlapService $overlapService,
        private TopicMatchStrengthService $matchStrengthService,
        private TopicKeywordDensityService $keywordDensityService,
        private TopicSourceDiversityService $sourceDiversityService,
        private TopicNoiseRatioService $noiseRatioService,
    ) {}

    public function analyze(
        Topic $topic
    ): TopicQualityData {

        return new TopicQualityData(

            topicId: $topic->id,

            topicName: $topic->name,

            coverage: $this->coverageService
                ->calculate($topic),

            overlapPercentage: $this->overlapService
                ->calculate($topic),

            averageScore: $this->matchStrengthService
                ->averageScore($topic),

            medianScore: $this->matchStrengthService
                ->medianScore($topic),

            averageKeywordCount: $this->keywordDensityService
                ->calculate($topic),

            sourceDiversity: $this->sourceDiversityService
                ->calculate($topic),

            noiseRatio: $this->noiseRatioService
                ->calculate($topic),
        );
    }
}
