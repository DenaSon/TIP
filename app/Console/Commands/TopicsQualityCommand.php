<?php

namespace App\Console\Commands;

use Domains\Topic\Models\Topic;
use Domains\Topic\Services\TopicQualityService;
use Illuminate\Console\Command;

class TopicsQualityCommand extends Command
{
    protected $signature =
        'topics:quality';

    protected $description =
        'Analyze topic quality metrics';

    public function handle(
        TopicQualityService $service
    ): int {

        $rows = [];

        Topic::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->each(function (
                Topic $topic
            ) use (
                &$rows,
                $service
            ) {

                $quality =
                    $service->analyze(
                        $topic
                    );

                $rows[] = [

                    $quality->topicName,

                    $quality->coverage,

                    $quality->overlapPercentage,

                    $quality->averageScore,

                    $quality->medianScore,

                    $quality->averageKeywordCount,

                    $quality->sourceDiversity,

                    $quality->noiseRatio,
                ];
            });

        $this->table(
            [
                'Topic',
                'Coverage',
                'Overlap %',
                'Avg Score',
                'Median',
                'Keyword Density',
                'Sources',
                'Noise %',
            ],
            $rows
        );

        return self::SUCCESS;
    }
}
