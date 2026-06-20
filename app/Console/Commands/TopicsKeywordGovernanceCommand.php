<?php

namespace App\Console\Commands;

use Domains\Topic\Models\Topic;
use Domains\Topic\Services\TopicKeywordGovernanceService;
use Illuminate\Console\Command;

class TopicsKeywordGovernanceCommand extends Command
{
    protected $signature =
        'topics:keyword-governance';

    protected $description =
        'Generate keyword governance report';

    public function handle(
        TopicKeywordGovernanceService $governanceService,
    ): int {

        Topic::query()
            ->where(
                'is_active',
                true
            )
            ->with('keywords')
            ->orderByDesc('id')
            ->each(function (
                Topic $topic
            ) use (
                $governanceService
            ) {

                $results =
                    $governanceService
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
                        90
                    )
                );

                $this->info(
                    $topic->name
                );

                $this->info(
                    str_repeat(
                        '=',
                        90
                    )
                );

                $this->table(
                    [
                        'Keyword',
                        'Action',
                        'Current',
                        'Recommended',
                        'Confidence',
                        'Auto Apply',
                    ],
                    collect($results)
                        ->map(
                            fn ($item) => [

                                $item->keyword,

                                $item->action->value,

                                $item->currentStatus->value,

                                $item->recommendedStatus->value,

                                $item->confidenceScore,

                                $item->autoApplicable
                                    ? 'YES'
                                    : '-',
                            ]
                        )
                        ->sortByDesc(
                            fn (array $row) =>
                            $row[4]
                        )
                        ->values()
                        ->all()
                );
            });

        return self::SUCCESS;
    }
}
