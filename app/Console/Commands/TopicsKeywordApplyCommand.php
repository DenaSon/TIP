<?php

namespace App\Console\Commands;

use Domains\Topic\Models\Topic;
use Domains\Topic\Services\TopicKeywordApplyService;
use Domains\Topic\Services\TopicKeywordGovernanceService;
use Illuminate\Console\Command;

class TopicsKeywordApplyCommand extends Command
{
    protected $signature =
        'topics:keyword-apply
        {--dry-run : Preview changes without applying them}';

    protected $description =
        'Apply keyword governance decisions';

    public function handle(
        TopicKeywordGovernanceService $governanceService,
        TopicKeywordApplyService $applyService,
    ): int {

        $dryRun =
            (bool) $this->option(
                'dry-run'
            );

        $affected = 0;

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
                $dryRun,
                $governanceService,
                $applyService,
                &$affected
            ) {

                if ($dryRun) {

                    $items =
                        collect(
                            $governanceService
                                ->analyze($topic)
                        )
                            ->filter(
                                fn ($item) =>
                                $item->autoApplicable
                            )
                            ->values();

                    if (
                        $items->isEmpty()
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
                        ],
                        $items
                            ->map(
                                fn ($item) => [

                                    $item->keyword,

                                    $item->action->value,

                                    $item->currentStatus->value,

                                    $item->recommendedStatus->value,

                                    $item->confidenceScore,
                                ]
                            )
                            ->all()
                    );

                    return;
                }

                $affected +=
                    $applyService
                        ->apply(
                            $topic
                        );
            });

        if ($dryRun) {

            $this->newLine();

            $this->warn(
                'DRY RUN ONLY - No changes were applied.'
            );

            return self::SUCCESS;
        }

        $this->newLine();

        $this->info(
            "Applied {$affected} keyword changes."
        );

        return self::SUCCESS;
    }
}
