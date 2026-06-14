<?php

namespace App\Jobs;

use Domains\Topic\Models\Topic;
use Domains\Trend\Actions\CalculateTrendAction;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\ThrottlesExceptions;
use Illuminate\Queue\SerializesModels;
use Throwable;

class CalculateTrendJob implements ShouldQueue
{
    use Batchable;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 3;

    public int $timeout = 30;

    public int $backoff = 10;

    public function __construct(
        public readonly int $topicId
    ) {}

    public function middleware(): array
    {
        return [
            new ThrottlesExceptions(
                maxAttempts: 3,
                decaySeconds: 60
            ),
        ];
    }

    public function handle(
        CalculateTrendAction $action
    ): void {

        $topic = Topic::query()
            ->find($this->topicId);

        if (! $topic) {
            return;
        }

        $action->execute($topic);
    }

    public function failed(
        Throwable $e
    ): void {

        logger()->error(
            'Trend calculation failed',
            [
                'topic_id' => $this->topicId,
                'error' => $e->getMessage(),
            ]
        );
    }
}
