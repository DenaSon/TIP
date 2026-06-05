<?php

namespace App\Jobs;

use Domains\Content\Models\Content;
use Domains\Topic\Actions\AssignTopicsAction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Throwable;

class AssignTopicsJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $timeout = 30;

    public function __construct(
        public Content $content,
    ) {}

    /**
     * @throws Throwable
     */
    public function handle(
        AssignTopicsAction $action,
    ): void {

        try {

            $action->execute(
                $this->content
            );

        } catch (Throwable $e) {

            logger()->error(
                'Topic assignment failed',
                [
                    'content_id' => $this->content->id,
                    'message' => $e->getMessage(),
                ]
            );

            throw $e;
        }
    }
}
