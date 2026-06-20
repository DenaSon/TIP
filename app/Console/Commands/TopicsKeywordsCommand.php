<?php

namespace App\Console\Commands;

use Domains\Topic\Models\Topic;
use Domains\Topic\Services\TopicKeywordAuditService;
use Illuminate\Console\Command;

class TopicsKeywordsCommand extends Command
{
    protected $signature =
        'topics:keywords';

    protected $description =
        'Generate keyword audit report';

    public function handle(
        TopicKeywordAuditService $auditService,
    ): int {

        Topic::query()
            ->where(
                'is_active',
                true
            )
            ->with('keywords')
            ->orderBy('name')
            ->each(function (
                Topic $topic
            ) use (
                $auditService
            ) {

                $results =
                    $auditService
                        ->analyze(
                            $topic
                        );

                if (empty($results)) {
                    return;
                }

                $this->newLine();

                $this->info(
                    str_repeat(
                        '=',
                        60
                    )
                );

                $this->info(
                    $topic->name
                );

                $this->info(
                    str_repeat(
                        '=',
                        60
                    )
                );

                $this->table(
                    [
                        'Keyword',
                        'Weight',
                        'Matches',
                        'Single',
                        'Single %',
                    ],
                    collect($results)
                        ->map(
                            fn ($item) => [

                                $item->keyword,

                                $item->weight,

                                $item->matchCount,

                                $item->singleKeywordMatchCount,

                                $item->singleKeywordPercentage.'%',
                            ]
                        )
                        ->all()
                );
            });

        return self::SUCCESS;
    }
}
