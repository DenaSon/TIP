<?php

namespace App\Console\Commands;

use Domains\Topic\Models\Topic;
use Domains\Topic\Services\TopicKeywordQualityService;
use Illuminate\Console\Command;

class TopicsKeywordQualityCommand extends Command
{
    protected $signature =
        'topics:keyword-quality';

    protected $description =
        'Generate keyword quality report';

    public function handle(
        TopicKeywordQualityService $qualityService,
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
                $qualityService
            ) {

                $results =
                    $qualityService
                        ->analyze(
                            $topic
                        );

                if (
                    empty($results)
                ) {
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
                        'Weight',
                        'Matches',
                        'Single %',
                        'Quality',
                        'Grade',
                    ],
                    collect($results)
                        ->map(
                            fn ($item) => [

                                $item->keyword,

                                $item->weight,

                                $item->matchCount,

                                $item->singleKeywordPercentage.'%',

                                $item->qualityScore,

                                $item->qualityGrade,
                            ]
                        )
                        ->all()
                );
            });

        return self::SUCCESS;
    }
}
