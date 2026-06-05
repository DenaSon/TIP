<?php

namespace App\Jobs;

use Domains\Content\Actions\StoreContentAction;
use Domains\DTOs\ContentData;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessContentJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $timeout = 30;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public ContentData $contentData
    ) {}

    /**
     * Execute the job.
     */
    public function handle(
        StoreContentAction $storeContentAction
    ): void {
        $content = $storeContentAction->execute(
            $this->contentData
        );
        AssignTopicsJob::dispatch(
            $content
        );
    }
}
