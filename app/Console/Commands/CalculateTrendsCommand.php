<?php

namespace App\Console\Commands;

use App\Jobs\CalculateTrendJob;
use Domains\Topic\Models\Topic;
use Illuminate\Console\Command;

class CalculateTrendsCommand extends Command
{
    protected $signature = 'trends:calculate';

    protected $description =
        'Calculate all trends';

    public function handle(): int
    {
        $topics = Topic::query()
            ->select([
                'id',
                'name',
            ])
            ->get();

        $this->info(
            "Dispatching {$topics->count()} topics..."
        );

        foreach ($topics as $topic) {

            CalculateTrendJob::dispatch(
                $topic
            );

            $this->line(
                "Queued: {$topic->name}"
            );
        }

        $this->info('Done.');

        return self::SUCCESS;
    }
}
