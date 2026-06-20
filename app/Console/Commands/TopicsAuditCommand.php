<?php

namespace App\Console\Commands;

use Domains\Topic\Models\Topic;
use Domains\Topic\Services\TopicAuditService;
use Illuminate\Console\Command;

class TopicsAuditCommand extends Command
{
    protected $signature =
        'topics:audit';

    protected $description =
        'Generate executive topic audit report';

    public function handle(
        TopicAuditService $auditService,
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
                $auditService
            ) {

                $audit =
                    $auditService
                        ->analyze($topic);

                $rows[] = [

                    $audit->topicName,

                    $audit->coverage,

                    $audit->sourceDiversity,

                    $audit->overlapPercentage . '%',

                    $audit->boundaryScore,

                    $audit->boundaryStatus,

                    $audit->highestOverlapTopic,

                    $audit->highestOverlapPercentage . '%',
                ];
            });

        $this->info('');
        $this->info('TIP Topic Audit Report');
        $this->info(str_repeat('=', 120));

        $this->table(
            [
                'Topic',
                'Coverage',
                'Sources',
                'Overlap',
                'Boundary',
                'Status',
                'Highest Overlap',
                'Overlap %',
            ],
            $rows
        );

        return self::SUCCESS;
    }
}
