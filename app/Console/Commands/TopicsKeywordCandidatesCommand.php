<?php

namespace App\Console\Commands;

use Domains\Topic\Models\Topic;
use Domains\Topic\Services\TopicKeywordCandidateService;
use Illuminate\Console\Command;

class TopicsKeywordCandidatesCommand extends Command
{
    protected $signature =
        'topics:keyword-candidates';

    protected $description =
        'Generate keyword candidate report';

    public function handle(
        TopicKeywordCandidateService $candidateService,
    ): int {

        Topic::query()
            ->where(
                'is_active',
                true
            )
            ->orderByDesc('id')
            ->lazy()
            ->each(function (
                Topic $topic
            ) use (
                $candidateService
            ) {

                $results =
                    $candidateService
                        ->analyze($topic);

                if (empty($results)) {
                    return;
                }

                $this->newLine();

                $this->info(
                    str_repeat(
                        '=',
                        70
                    )
                );

                $this->info(
                    $topic->name
                );

                $this->info(
                    str_repeat(
                        '=',
                        70
                    )
                );

                $this->table(
                    [
                        'Keyword',
                        'Action',
                        'Grade',
                        'Reason',
                    ],
                    collect($results)
                        ->map(
                            fn ($item) => [

                                $item->keyword,

                                $item->action->value,

                                $item->qualityGrade->value,

                                $item->reason,
                            ]
                        )
                        ->all()
                );
            });

        return self::SUCCESS;
    }
}
