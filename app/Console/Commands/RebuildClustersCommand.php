<?php

namespace App\Console\Commands;

use Domains\Cluster\Actions\RebuildClustersAction;
use Illuminate\Console\Command;
use Throwable;

class RebuildClustersCommand extends Command
{
    protected $signature =
        'clusters:rebuild';

    protected $description =
        'Rebuild all clusters';

    public function handle(
        RebuildClustersAction $action
    ): int {

        $this->info(
            'Rebuilding clusters...'
        );

        try {

            $action->execute();

            $this->info(
                'Clusters rebuilt successfully.'
            );

            return self::SUCCESS;

        } catch (Throwable $e) {

            report($e);

            $this->error(
                $e->getMessage()
            );

            return self::FAILURE;
        }
    }
}
