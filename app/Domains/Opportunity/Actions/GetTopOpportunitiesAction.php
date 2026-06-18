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
        int $limit = 20,
    ): Collection {

        return Trend::query()
            ->with('topic')
            ->orderByDesc('score')
            ->limit($limit)
            ->get()
            ->map(function (
                Trend $trend
            ) {

                return (object) [

                    'topic' => $trend->topic,

                    'trend' => $trend,

                    'details' => $this
                        ->detailsService
                        ->build($trend),

                ];
            });
    }
}
