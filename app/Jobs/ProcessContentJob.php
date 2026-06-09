<?php

namespace App\Jobs;

use Domains\Content\Actions\StoreContentAction;
use Domains\DTOs\ContentData;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessContentJob implements ShouldQueue
{
    use Batchable, Queueable;

    public int $tries = 2;

    public int $timeout = 60;

    public function __construct(
        public ContentData $contentData
    ) {}

    public function handle(
        StoreContentAction $storeContentAction
    ): void {
        if ($this->batch()?->cancelled()) {
            return;
        }

        $content = $storeContentAction->execute(
            $this->contentData
        );

        // fan-out controlled
        AssignTopicsJob::dispatch($content->id)
            ->onQueue('topic-assignment');
    }
}
