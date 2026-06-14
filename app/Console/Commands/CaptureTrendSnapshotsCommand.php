<?php

namespace App\Console\Commands;

use Domains\Trend\Actions\CaptureTrendSnapshotsAction;
use Illuminate\Console\Command;

class CaptureTrendSnapshotsCommand extends Command
{
    protected $signature =
        'trends:snapshot';

    protected $description =
        'Capture topic trend snapshots';

    public function handle(
        CaptureTrendSnapshotsAction $action
    ): int {

        $count = $action->execute();

        $this->info(
            "{$count} snapshots created."
        );

        return self::SUCCESS;
    }
}
