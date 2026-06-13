<?php

namespace App\Console\Commands;

use Domains\Topic\Models\Topic;
use Domains\Trend\Models\TrendSnapshot;
use Illuminate\Console\Command;

class CaptureTrendSnapshotsCommand extends Command
{
    protected $signature =
        'trends:snapshot';

    protected $description =
        'Capture topic trend snapshots';

    public function handle(): int
    {
        $created = 0;

        Topic::query()

            ->withCount('contents')

            ->chunkById(
                100,
                function ($topics)
                use (&$created) {

                    foreach ($topics as $topic) {

                        TrendSnapshot::create([
                            'topic_id' =>
                                $topic->id,

                            'content_count' =>
                                $topic->contents_count,

                            'captured_at' =>
                                now(),
                        ]);

                        $created++;
                    }
                }
            );

        $this->info(
            "{$created} snapshots created."
        );

        return self::SUCCESS;
    }
}
