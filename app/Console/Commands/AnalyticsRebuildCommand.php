<?php

namespace App\Console\Commands;

use Domains\Analytics\Actions\AnalyticsRebuildAction;
use Illuminate\Console\Command;

class AnalyticsRebuildCommand extends Command
{
    protected $signature =
        'analytics:rebuild';

    protected $description =
        'Rebuild analytics pipeline';

    public function handle(
        AnalyticsRebuildAction $action
    ): int {

        $this->info(
            'Starting analytics rebuild...'
        );

        $action->execute();

        $this->info(
            'Analytics pipeline queued.'
        );

        return self::SUCCESS;
    }
}
