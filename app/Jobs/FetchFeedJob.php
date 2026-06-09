<?php

namespace App\Jobs;

use Carbon\CarbonInterface;
use Domains\Source\Actions\FetchFeedAction;
use Domains\Source\Models\Source;
use Domains\Source\Services\FeedParser;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Queue\Middleware\SkipIfBatchCancelled;
use Illuminate\Support\Facades\Bus;
use Throwable;

class FetchFeedJob implements ShouldQueue
{
    use Batchable, Queueable;

    /**
     * فقط یک retry layer نگه داشته شده
     */
    public int $tries = 3;

    public int $timeout = 20;

    public int $backoff = 60;

    public function __construct(
        public readonly Source $source,
    ) {
        $this->onQueue('collect-content');
    }

    /**
     * Simplified middleware stack (no overlap retries)
     */
    public function middleware(): array
    {
        return [
            new SkipIfBatchCancelled,

            /**
             * فقط concurrency control
             * (هیچ retry logic اینجا نیست)
             */
            new RateLimited('feed-fetching'),
        ];
    }

    public function retryUntil(): CarbonInterface
    {
        return now()->addMinutes(5);
    }

    /**
     * @throws Throwable
     * @throws ConnectionException
     */
    public function handle(
        FetchFeedAction $fetchFeedAction,
        FeedParser $feedParser,
    ): void {
        if ($this->batch()?->cancelled()) {
            return;
        }

        try {
            $xml = $fetchFeedAction->execute($this->source);
            $items = $feedParser->parse($this->source, $xml);
        } catch (Throwable $e) {
            /**
             * فقط network / runtime fail اینجا retry میشه
             * parsing fail وارد retry storm نمیشه
             */
            throw $e;
        }

        // empty feed = valid state (NOT failure)
        if (empty($items)) {
            $this->source->updateQuietly([
                'last_crawled_at' => now(),
                'last_item_count' => 0,
                'ingestion_status' => 'empty',
            ]);

            return;
        }

        $batch = Bus::batch(
            collect($items)
                ->map(fn ($item) => new ProcessContentJob($item))
                ->toArray()
        )
            ->name("source:{$this->source->id}:content-ingestion")
            ->onQueue('collect-content')
            ->allowFailures()
            ->dispatch();

        $this->source->updateQuietly([
            'last_crawled_at' => now(),
            'last_item_count' => count($items),
            'last_batch_id' => $batch->id,
            'ingestion_status' => 'processing',
        ]);
    }

    public function failed(Throwable $exception): void
    {
        $this->source->updateQuietly([
            'last_failed_at' => now(),
            'last_error' => $exception->getMessage(),
            'ingestion_status' => 'failed',
        ]);
    }
}
