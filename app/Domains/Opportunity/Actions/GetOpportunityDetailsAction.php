<?php

namespace Domains\Opportunity\Actions;

use Domains\Opportunity\Services\OpportunityDetailsService;
use Domains\Topic\Models\Topic;
use Domains\Topic\Services\TopicProfileService;
use Domains\Trend\Models\Trend;

readonly class GetOpportunityDetailsAction
{
    public function __construct(
        private OpportunityDetailsService $opportunityService,
        private TopicProfileService $profileService,
    ) {}

    public function execute(
        Topic $topic
    ): array {

        $trend = Trend::query()
            ->where('topic_id', $topic->id)
            ->firstOrFail();

        return [

            'trend' => $trend,

            'opportunity' => $this
                ->opportunityService
                ->build($trend),

            'profile' => $this
                ->profileService
                ->build($trend),
        ];
    }
}
