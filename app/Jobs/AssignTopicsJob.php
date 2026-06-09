<?php

namespace App\Jobs;

use Domains\Content\Models\Content;
use Domains\Topic\Actions\AssignTopicsAction;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\Middleware\SkipIfBatchCancelled;
use Illuminate\Queue\Middleware\ThrottlesExceptions;
use Throwable;

class AssignTopicsJob implements ShouldQueue
{
    use Batchable, Queueable;

    public int $tries = 3;

    public int $timeout = 30;

    public int $backoff = 10;

    public function __construct(
        public readonly int $contentId
    ) {}

    public function middleware(): array
    {
        return [
            new SkipIfBatchCancelled,
            new ThrottlesExceptions(maxAttempts: 3, decaySeconds: 60),
        ];
    }

    public function handle(
        AssignTopicsAction $action
    ): void {
        if ($this->batch()?->cancelled()) {
            return;
        }

        $content = Content::find($this->contentId);

        if (! $content) {
            return;
        }

        $action->execute($content);
    }

    public function failed(Throwable $e): void
    {
        logger()->error('Topic assignment failed', [
            'content_id' => $this->contentId,
            'error' => $e->getMessage(),
        ]);
    }
}
