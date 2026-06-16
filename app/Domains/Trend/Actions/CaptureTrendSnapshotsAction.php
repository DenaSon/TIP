<?php

namespace Domains\Trend\Actions;

use Domains\Topic\Models\Topic;
use Domains\Trend\Models\TrendSnapshot;

class CaptureTrendSnapshotsAction
{
    public function execute(): int
    {
        $created = 0;

        Topic::query()
            ->where('is_active', true)
            ->withCount('contents')
            ->chunkById(
                100,
                function ($topics) use (&$created) {

                    foreach ($topics as $topic) {

                        TrendSnapshot::create([
                            'topic_id' => $topic->id,

                            'content_count' => $topic->contents_count,

                            'captured_at' => now(),
                        ]);

                        $created++;
                    }
                }
            );

        return $created;
    }
}
