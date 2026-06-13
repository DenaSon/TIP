<?php

namespace App\Console\Commands;

use App\Jobs\AssignTopicsJob;
use Domains\Content\Models\Content;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RebuildTopicsCommand extends Command
{
    protected $signature = 'topics:rebuild';

    protected $description =
        'Rebuild topic assignments for all contents';

    public function handle(): int
    {
        $this->warn(
            'Clearing existing topic assignments...'
        );

        DB::table('content_topic')->delete();

        $count = Content::count();

        $this->info("Contents: {$count}");
        $this->info('Queueing jobs...');

        Content::query()

            ->select('id')

            ->chunkById(
                100,
                function ($contents) {

                    foreach ($contents as $content) {

                        AssignTopicsJob::dispatch(
                            $content->id
                        );
                    }
                }
            );

        $this->info(
            "{$count} topic assignment jobs queued."
        );

        return self::SUCCESS;
    }
}
