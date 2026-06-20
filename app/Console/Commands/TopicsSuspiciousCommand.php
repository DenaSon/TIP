<?php

namespace App\Console\Commands;

use Domains\Topic\Models\ContentTopicMatch;
use Domains\Topic\Services\TopicAuditContextService;
use Domains\Topic\Services\TopicMatchAuditService;
use Illuminate\Console\Command;

class TopicsSuspiciousCommand extends Command
{
    protected $signature =
        'topics:suspicious';

    protected $description =
        'Show suspicious topic matches';

    public function handle(
        TopicAuditContextService $contextService,
        TopicMatchAuditService $auditService,
    ): int {

        $contexts =
            $contextService->build();

        $rows = [];

        ContentTopicMatch::query()
            ->orderByDesc('score')
            ->get()
            ->each(function (
                ContentTopicMatch $match
            ) use (
                &$rows,
                $contexts,
                $auditService
            ) {

                $context =
                    $contexts[$match->topic_id] ?? null;

                if (! $context) {
                    return;
                }

                $audit =
                    $auditService
                        ->analyze(
                            match: $match,
                            context: $context,
                        );

                if (! $audit->requiresReview) {
                    return;
                }

                $rows[] = [

                    $audit->contentId,

                    $audit->topicName,

                    $audit->score,

                    $audit->keywordCount,

                    $audit->confidenceScore,

                    implode(
                        ', ',
                        $audit->reasons
                    ),
                ];
            });

        $this->info('');
        $this->info(
            'Suspicious Topic Matches'
        );

        $this->info(
            str_repeat(
                '=',
                120
            )
        );

        $this->table(
            [
                'Content',
                'Topic',
                'Score',
                'Keywords',
                'Confidence',
                'Reasons',
            ],
            $rows
        );

        return self::SUCCESS;
    }
}
