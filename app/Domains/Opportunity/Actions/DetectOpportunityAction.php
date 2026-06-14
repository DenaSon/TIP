<?php

namespace Domains\Opportunity\Actions;

use Domains\Opportunity\Models\Opportunity;
use Domains\Opportunity\Services\OpportunityReasonService;
use Domains\Opportunity\Services\OpportunityScoreService;
use Domains\Trend\Models\Trend;

readonly class DetectOpportunityAction
{
    public function __construct(
        private OpportunityScoreService  $scoreService,
        private OpportunityReasonService $reasonService,
    ) {
    }

    public function execute(
        Trend $trend
    ): void {

        $topic = $trend->topic;

        if (! $topic) {
            return;
        }

        $score = $this->scoreService
            ->calculate(
                $topic,
                $trend
            );

        $reason = $this->reasonService
            ->generate(
                $topic,
                $trend
            );

        Opportunity::query()
            ->updateOrCreate(
                [
                    'trend_id' => $trend->id,
                ],
                [
                    'topic_id' => $topic->id,

                    'title' => $topic->name,

                    'score' => $score,

                    'reason' => $reason,

                    'detected_at' => now(),
                ]
            );
    }
}
