<?php

namespace Domains\Cluster\Actions;

use Domains\Cluster\Models\Cluster;
use Domains\Topic\Models\Topic;
use Illuminate\Support\Collection;

class RebuildClustersAction
{
    public function execute(): void
    {
        Cluster::query()->delete();

        Topic::query()
            ->select([
                'id',
                'name',
            ])
            ->chunkById(
                100,
                function ($topics): void {

                    foreach ($topics as $topic) {

                        $this->buildCluster(
                            $topic->id
                        );
                    }
                }
            );
    }

    private function buildCluster(
        int $topicId
    ): void {

        $topic = Topic::query()
            ->select([
                'id',
                'name',
            ])
            ->find($topicId);

        if (! $topic) {
            return;
        }

        $contents = $topic
            ->contents()
            ->select([
                'contents.id',
                'contents.published_at',
            ])
            ->get();

        if ($contents->isEmpty()) {
            return;
        }

        $cluster = Cluster::query()
            ->create([
                'topic_id' => $topic->id,

                'name' => $topic->name,

                'content_count' => $contents->count(),

                'last_content_at' => $contents
                    ->max('published_at'),
            ]);

        $cluster->contents()
            ->sync(
                $contents
                    ->pluck('id')
                    ->all()
            );
    }
}
