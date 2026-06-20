<?php

namespace App\Console\Commands;

use Domains\Topic\Models\Topic;
use Domains\Topic\Services\TopicKeywordLifecycleService;
use Illuminate\Console\Command;

class TopicsKeywordLifecycleCommand extends Command
{
    protected $signature =
        'topics:keyword-lifecycle';

    protected $description =
        'Generate keyword lifecycle report';

    public function handle(
        TopicKeywordLifecycleService $lifecycleService,
    ): int {

        Topic::query()
            ->where(
                'is_active',
                true
            )
            ->with('keywords')
            ->lazy()
            ->each(function (
                Topic $topic
            ) use (
                $lifecycleService
            ) {

                $results =
                    $lifecycleService
                        ->analyze($topic);

                if (
                    empty($results)
                ) {
                    return;
                }

                $this->newLine();

                $this->info(
                    str_repeat(
                        '=',
                        80
                    )
                );

                $this->info(
                    $topic->name
                );

                $this->info(
                    str_repeat(
                        '=',
                        80
                    )
                );

                $this->table(
                    [
                        'Keyword',
                        'Current',
                        'Recommended',
                        'Action',
                        'Reason',
                    ],
                    collect($results)
                        ->map(
                            fn ($item) => [

                                $item->keyword,

                                $item->currentStatus->value,

                                $item->recommendedStatus->value,

                                $item->action->value,

                                $item->reason,
                            ]
                        )
                        ->all()
                );
            });

        return self::SUCCESS;
    }
}
