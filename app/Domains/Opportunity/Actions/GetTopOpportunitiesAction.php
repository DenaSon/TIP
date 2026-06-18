<?php

namespace Domains\Opportunity\Actions;

use Domains\Opportunity\Services\OpportunityDetailsService;
use Domains\Trend\Models\Trend;
use Illuminate\Support\Collection;

readonly class GetTopOpportunitiesAction
{
    public function __construct(
        private OpportunityDetailsService $detailsService,
    ) {}

    public function execute(
        int $limit = 9
    ): \Illuminate\Database\Eloquent\Collection|Collection {
        return Trend::query()
            ->with('topic')
            ->orderByDesc('score')
            ->limit($limit)
            ->get()
            ->map(
                fn (Trend $trend) => (object) [
                    'topic' => $trend->topic,
                    'details' => $this->detailsService
                        ->build($trend),
                ]
            );

    }
}
