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

        $audits = Topic::query()
            ->where(
                'is_active',
                true
            )
            ->get()
            ->map(
                fn (Topic $topic) =>
                $auditService->analyze(
                    $topic
                )
            )
            ->sortBy([
                fn ($audit) =>
                $audit->requiresReview
                    ? 0
                    : 1,

                fn ($audit) =>
                $audit->boundaryScore,
            ]);

        $rows = $audits
            ->map(fn ($audit) => [

                $audit->topicName,

                $audit->coverage,

                $audit->sourceDiversity,

                $audit->overlapPercentage . '%',

                $audit->boundaryScore,

                $audit->boundaryStatus,

                $audit->highestOverlapTopic,

                $audit->highestOverlapPercentage . '%',

                $audit->requiresReview
                    ? 'YES'
                    : '-',
            ])
            ->all();

        $this->info('');
        $this->info(
            'TIP Topic Audit Report'
        );

        $this->info(
            str_repeat(
                '=',
                120
            )
        );

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
                'Review',
            ],
            $rows
        );

        return self::SUCCESS;
    }
}
