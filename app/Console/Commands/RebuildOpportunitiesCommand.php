<?php

namespace App\Console\Commands;

use App\Jobs\DetectOpportunityJob;
use Domains\Opportunity\Models\Opportunity;
use Domains\Trend\Models\Trend;
use Illuminate\Console\Command;

class RebuildOpportunitiesCommand extends Command
{
    protected $signature =
        'opportunities:rebuild';

    protected $description =
        'Rebuild all opportunities';

    public function handle(): int
    {
        $this->info(
            'Clearing opportunities...'
        );

        Opportunity::query()->delete();

        $count = Trend::query()->count();

        $this->info(
            "Dispatching {$count} trends..."
        );

        Trend::query()
            ->select('id')
            ->chunkById(
                100,
                function ($trends): void {

                    foreach (
                        $trends as $trend
                    ) {

                        DetectOpportunityJob::dispatch(
                            $trend->id
                        );
                    }
                }
            );

        $this->info(
            'Opportunity rebuild queued.'
        );

        return self::SUCCESS;
    }
}
