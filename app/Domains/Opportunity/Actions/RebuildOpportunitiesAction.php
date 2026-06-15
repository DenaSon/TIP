<?php

namespace Domains\Opportunity\Actions;

use App\Jobs\DetectOpportunityJob;
use Domains\Opportunity\Models\Opportunity;
use Domains\Trend\Models\Trend;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;

class RebuildOpportunitiesAction
{
    public function execute(
        ?callable $then = null
    ): Batch {

        // Opportunity::query()->delete();

        $jobs = [];

        Trend::query()
            ->select('id')
            ->chunkById(
                100,
                function ($trends) use (&$jobs) {

                    foreach ($trends as $trend) {

                        $jobs[] =
                            new DetectOpportunityJob(
                                $trend->id
                            );
                    }
                }
            );

        $batch = Bus::batch($jobs)
            ->name('Opportunity Rebuild');

        if ($then) {
            $batch->then($then);
        }

        return $batch->dispatch();
    }
}
