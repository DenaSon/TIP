<?php

namespace App\Jobs;

use Domains\Topic\Models\Topic;
use Domains\Trend\Actions\CalculateTrendAction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CalculateTrendJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $timeout = 30;

    public function __construct(
        public Topic $topic
    ) {}

    /**
     * @throws \Throwable
     */
    public function handle(
        CalculateTrendAction $action
    ): void {

        $action->execute(
            $this->topic
        );
    }
}
