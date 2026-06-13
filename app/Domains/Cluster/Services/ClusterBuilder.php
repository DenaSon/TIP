<?php

namespace Domains\Cluster\Services;

use Domains\Cluster\Models\Cluster;
use Domains\Topic\Models\Topic;

class ClusterBuilder
{
    public function __construct(
        private readonly ClusterSignatureService $signatureService,
    ) {}

    public function build(Topic $topic): void
    {
        $contents = $topic
            ->contents()
            ->select([
                'contents.id',
                'contents.title',
                'contents.published_at',
            ])
            ->get();

        if ($contents->isEmpty()) {
            return;
        }

        $groups = [];

        foreach ($contents as $content) {

            $signature = $this->signatureService
                ->generate($content->title);

            $groups[$signature][] = $content;
        }

        foreach ($groups as $signature => $items) {

            $this->createCluster(
                $topic,
                $signature,
                collect($items)
            );
        }
    }

    private function createCluster(
        Topic $topic,
        string $signature,
        $contents
    ): void {

        $cluster = Cluster::query()
            ->create([
                'topic_id' => $topic->id,

                'name' => $signature,

                'content_count' => $contents->count(),

                'last_content_at' => $contents
                    ->max('published_at'),
            ]);

        $cluster->contents()->sync(
            $contents
                ->pluck('id')
                ->all()
        );
    }
}
