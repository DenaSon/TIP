<?php

namespace App\Jobs;

use Domains\Opportunity\Actions\DetectOpportunityAction;
use Domains\Trend\Models\Trend;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\ThrottlesExceptions;
use Illuminate\Queue\SerializesModels;
use Throwable;

class DetectOpportunityJob implements ShouldQueue
{
    use Batchable;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 1;

    public int $timeout = 30;

    public int $backoff = 10;

    public function __construct(
        public readonly int $trendId
    ) {}

    //    public function middleware(): array
    //    {
    //        return [
    //            new ThrottlesExceptions(
    //                maxAttempts: 3,
    //                decaySeconds: 60
    //            ),
    //        ];
    //    }

    public function handle(
        DetectOpportunityAction $action
    ): void {

        $trend = Trend::query()
            ->with('topic')
            ->find($this->trendId);

        if (! $trend) {
            return;
        }

        $action->execute($trend);
    }

    public function failed(
        Throwable $e
    ): void {

        logger()->error(
            'Opportunity detection failed',
            [
                'trend_id' => $this->trendId,
                'error' => $e->getMessage(),
            ]
        );
    }
}
