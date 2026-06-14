<?php

namespace App\Console\Commands;

use Domains\Trend\Actions\RebuildTrendsAction;
use Illuminate\Console\Command;

class CalculateTrendsCommand extends Command
{
    protected $signature =
        'trends:rebuild';

    protected $description =
        'Rebuild all trends';

    public function handle(
        RebuildTrendsAction $action
    ): int {

        $batch = $action->execute();

        $this->info(
            "Trend batch queued: {$batch->id}"
        );

        return self::SUCCESS;
    }
}
