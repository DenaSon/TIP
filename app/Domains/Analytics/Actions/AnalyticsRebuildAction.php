<?php

namespace Domains\Analytics\Actions;

use Domains\Cluster\Actions\RebuildClustersAction;
use Domains\Opportunity\Actions\RebuildOpportunitiesAction;
use Domains\Trend\Actions\CaptureTrendSnapshotsAction;
use Domains\Trend\Actions\RebuildTrendsAction;

readonly class AnalyticsRebuildAction
{
    public function __construct(
        private RebuildClustersAction $clusters,
        private CaptureTrendSnapshotsAction $snapshots,
        private RebuildTrendsAction $trends,
        private RebuildOpportunitiesAction $opportunities,
    ) {}

    public function execute(): void
    {
        /*
         * Stage 1
         */
        $this->clusters->execute();

        /*
         * Stage 2
         */
        $this->snapshots->execute();

        /*
         * Stage 3 -> Stage 4
         */
        $this->trends->execute(
            then: function () {

                $this->opportunities->execute();

            }
        );
    }
}
