<?php

namespace App\Console\Commands;

use Domains\Opportunity\Actions\RebuildOpportunitiesAction;
use Illuminate\Console\Command;

class RebuildOpportunitiesCommand extends Command
{
    protected $signature =
        'opportunities:rebuild';

    protected $description =
        'Rebuild all opportunities';

    public function handle(
        RebuildOpportunitiesAction $action
    ): int {

        $batch = $action->execute();

        $this->info(
            "Opportunity batch queued: {$batch->id}"
        );

        return self::SUCCESS;
    }
}
