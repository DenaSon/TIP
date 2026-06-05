<?php

namespace Domains\Cluster\Actions;

use Domains\Cluster\Models\Cluster;
use Domains\Topic\Models\Topic;
use Illuminate\Support\Facades\DB;
use Throwable;

class RebuildClustersAction
{
    public function execute(): void
    {
        DB::transaction(function () {

            DB::table('cluster_content')
                ->truncate();

            Cluster::query()
                ->delete();

            Topic::query()
                ->with('contents')
                ->chunkById(
                    100,
                    function ($topics) {

                        foreach ($topics as $topic) {

                            $this->buildCluster(
                                $topic
                            );
                        }
                    }
                );
        });
    }

    private function buildCluster(
        Topic $topic
    ): void {

        $contents = $topic->contents;

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
            ->syncWithoutDetaching(
                $contents->pluck('id')
            );
    }
}
