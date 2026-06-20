<?php

namespace App\Console\Commands;

use Domains\Topic\Models\Topic;
use Domains\Topic\Services\TopicOverlapMatrixService;
use Illuminate\Console\Command;

class TopicsOverlapCommand extends Command
{
    protected $signature =
        'topics:overlap';

    protected $description =
        'Analyze topic overlap matrix';

    public function handle(
        TopicOverlapMatrixService $service
    ): int {

        $topics =
            Topic::query()
                ->where(
                    'is_active',
                    true
                )
                ->orderBy('name')
                ->get();

        foreach ($topics as $topic) {

            $this->newLine();

            $this->info(
                str_repeat('=', 60)
            );

            $this->info(
                $topic->name
            );

            $this->info(
                str_repeat('=', 60)
            );

            $rows = [];

            foreach (
                $service->analyze($topic) as $overlap
            ) {

                $rows[] = [

                    $overlap->overlappingTopicName,

                    $overlap->sharedContents,

                    $overlap->overlapPercentage,
                ];
            }

            $this->table(
                [
                    'Topic',
                    'Shared',
                    'Overlap %',
                ],
                $rows
            );
        }

        return self::SUCCESS;
    }
}
