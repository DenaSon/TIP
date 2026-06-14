<?php

namespace Domains\Trend\Actions;

use App\Jobs\CalculateTrendJob;
use Domains\Topic\Models\Topic;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;

class RebuildTrendsAction
{
    public function execute(
        ?callable $then = null
    ): Batch {

        $jobs = [];

        Topic::query()
            ->select('id')
            ->chunkById(
                100,
                function ($topics) use (&$jobs) {

                    foreach ($topics as $topic) {

                        $jobs[] =
                            new CalculateTrendJob(
                                $topic->id
                            );
                    }
                }
            );

        $batch = Bus::batch($jobs)
            ->name('Trend Rebuild');

        if ($then) {
            $batch->then($then);
        }

        return $batch->dispatch();
    }
}
