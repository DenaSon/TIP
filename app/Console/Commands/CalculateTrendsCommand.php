<?php

namespace App\Console\Commands;

use App\Jobs\CalculateTrendJob;
use Domains\Topic\Models\Topic;
use Illuminate\Console\Command;

class CalculateTrendsCommand extends Command
{
    protected $signature = 'trends:rebuild';

    protected $description =
        'Calculate all trends';

    public function handle(): int
    {
        Topic::query()
            ->select('id')
            ->chunkById(
                100,
                function ($topics) {

                    foreach ($topics as $topic) {

                        CalculateTrendJob::dispatch(
                            $topic->id
                        );
                    }
                }
            );

        $this->info('Done.');

        return self::SUCCESS;
    }
}
