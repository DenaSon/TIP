<?php

namespace Domains\Cluster\Actions;

use Domains\Cluster\Models\Cluster;
use Domains\Cluster\Services\ClusterBuilder;
use Domains\Topic\Models\Topic;

readonly class RebuildClustersAction
{
    public function __construct(
        private ClusterBuilder $builder,
    ) {}

    public function execute(): void
    {
        Cluster::query()->delete();

        Topic::query()
            ->where('is_active', true)
            ->select([
                'id',
                'name',
            ])
            ->chunkById(
                100,
                function ($topics): void {

                    foreach ($topics as $topic) {

                        $this->builder->build(
                            $topic
                        );
                    }
                }
            );
    }
}
