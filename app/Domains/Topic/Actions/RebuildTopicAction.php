<?php

namespace Domains\Topic\Actions;

use Domains\Cluster\Services\ClusterBuilder;
use Domains\Opportunity\Actions\DetectOpportunityAction;
use Domains\Topic\Models\Topic;
use Domains\Trend\Actions\CalculateTrendAction;
use Domains\Trend\Models\TrendSnapshot;
use Domains\Topic\Actions\RefreshTopicMatchesAction;
readonly class RebuildTopicAction
{
    public function __construct(
        private readonly RefreshTopicMatchesAction $matchesAction,
        private readonly ClusterBuilder $clusterBuilder,
        private readonly CalculateTrendAction $trendAction,
        private readonly DetectOpportunityAction $opportunityAction,
    ) {}

    public function execute(
        Topic $topic
    ): void {

        /*
        |--------------------------------------------------------------------------
        | Snapshot
        |--------------------------------------------------------------------------
        */
        $this->matchesAction
            ->execute($topic);
        TrendSnapshot::query()
            ->create([
                'topic_id' => $topic->id,

                'content_count' => $topic->contents()
                    ->count(),

                'captured_at' => now(),
            ]);

        /*
        |--------------------------------------------------------------------------
        | Clusters
        |--------------------------------------------------------------------------
        */

        $topic->clusters()
            ->delete();

        $this->clusterBuilder
            ->build($topic);

        /*
        |--------------------------------------------------------------------------
        | Trend
        |--------------------------------------------------------------------------
        */

        $this->trendAction
            ->execute($topic);

        /*
        |--------------------------------------------------------------------------
        | Opportunity
        |--------------------------------------------------------------------------
        */

        $topic->load('trend');

        if ($topic->trend) {

            $this->opportunityAction
                ->execute(
                    $topic->trend
                );
        }
    }
}
