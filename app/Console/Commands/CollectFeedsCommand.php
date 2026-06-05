<?php

namespace App\Console\Commands;

use App\Jobs\FetchFeedJob;
use Domains\Source\Models\Source;
use Illuminate\Console\Command;

class CollectFeedsCommand extends Command
{
    protected $signature = 'feeds:collect';

    protected $description = 'Collect content from all active RSS sources';

    public function handle(): int
    {
        $sources = Source::query()
            ->where('status', Source::STATUS_ACTIVE)
            ->where('type', Source::TYPE_RSS)
            ->get();

        $this->info(
            "Dispatching {$sources->count()} source(s)..."
        );

        foreach ($sources as $source) {

            FetchFeedJob::dispatch($source);

            $this->line(
                "Queued: {$source->name}"
            );
        }

        $this->info('Done.');

        return self::SUCCESS;
    }
}
