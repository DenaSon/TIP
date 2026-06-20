<?php

namespace App\Console\Commands;

use Domains\Topic\Models\Topic;
use Domains\Topic\Services\TopicBoundaryAnalysisService;
use Illuminate\Console\Command;

class TopicsBoundaryCommand extends Command
{
    protected $signature =
        'topics:boundary';

    protected $description =
        'Analyze topic boundaries';

    public function handle(
        TopicBoundaryAnalysisService $service
    ): int {

        $rows = [];

        Topic::query()
            ->where(
                'is_active',
                true
            )
            ->orderBy('name')
            ->each(function (
                Topic $topic
            ) use (
                &$rows,
                $service
            ) {

                $analysis =
                    $service->analyze(
                        $topic
                    );

                $rows[] = [

                    $analysis->topicName,

                    $analysis->boundaryScore,

                    $analysis->boundaryStatus,

                    $analysis->highestOverlapTopic,

                    $analysis->highestOverlapPercentage,
                ];
            });

        $this->table(
            [
                'Topic',
                'Boundary Score',
                'Status',
                'Highest Overlap',
                'Overlap %',
            ],
            $rows
        );

        return self::SUCCESS;
    }
}
