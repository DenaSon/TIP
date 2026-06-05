<?php

namespace App\Jobs;

use Domains\Source\Actions\FetchFeedAction;
use Domains\Source\Models\Source;
use Domains\Source\Services\FeedParser;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class FetchFeedJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $timeout = 60;

    public function __construct(
        public Source $source,
    ) {}

    /**
     * @throws Exception
     */
    public function handle(
        FetchFeedAction $fetchFeedAction,
        FeedParser $feedParser,
    ): void {

        $xml = $fetchFeedAction->execute(
            $this->source
        );

        $items = $feedParser->parse(
            $this->source,
            $xml
        );

        if (empty($items)) {
            return;
        }

        foreach ($items as $item) {

            ProcessContentJob::dispatch(
                $item
            );
        }

        $this->source->update([
            'last_crawled_at' => now(),
        ]);
    }
}
