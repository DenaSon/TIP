<?php

namespace App\Console\Commands;

use DB;
use Domains\Content\Models\Content;
use Domains\Opportunity\Models\Opportunity;
use Domains\Topic\Models\Topic;
use Domains\Trend\Models\Trend;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Command;

#[Description('Command description')]
class TipAuditCommand extends Command
{
    protected $signature = 'audit:run';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->coverage();

        $this->topicDistribution();

        $this->trendMetrics();

        $this->opportunities();

        $this->overlapDistribution();

        $this->unassignedSources();

        $this->unassignedAiCandidates();

        $this->unassignedAiCandidatesSummary();

        $this->unmatchedKeywordHints();

        return self::SUCCESS;
    }
    private function unassignedSources(): void
    {
        $rows = Content::query()

            ->selectRaw('
            sources.name as source_name,
            count(*) as missed
        ')

            ->join(
                'sources',
                'sources.id',
                '=',
                'contents.source_id'
            )

            ->whereNotExists(
                function ($query) {

                    $query
                        ->select(DB::raw(1))
                        ->from('content_topic')
                        ->whereColumn(
                            'content_topic.content_id',
                            'contents.id'
                        );
                }
            )

            ->groupBy('sources.id', 'sources.name')

            ->orderByDesc('missed')

            ->limit(20)

            ->get()

            ->map(fn ($row) => [

                $row->source_name,

                $row->missed,
            ])

            ->toArray();

        $this->newLine();

        $this->info('UNASSIGNED BY SOURCE');

        $this->table(
            [
                'Source',
                'Unassigned',
            ],
            $rows
        );
    }

    private function unassignedAiCandidates(): void
    {
        $rows = Content::query()

            ->select([
                'id',
                'title',
            ])

            ->where(function ($query) {

                $query

                    ->orWhere(
                        'title',
                        'like',
                        '%AI%'
                    )

                    ->orWhere(
                        'title',
                        'like',
                        '%agent%'
                    )

                    ->orWhere(
                        'title',
                        'like',
                        '%model%'
                    )

                    ->orWhere(
                        'title',
                        'like',
                        '%GPT%'
                    )

                    ->orWhere(
                        'title',
                        'like',
                        '%Claude%'
                    )

                    ->orWhere(
                        'title',
                        'like',
                        '%Gemini%'
                    )

                    ->orWhere(
                        'title',
                        'like',
                        '%reasoning%'
                    );
            })

            ->whereNotExists(
                function ($query) {

                    $query
                        ->select(DB::raw(1))
                        ->from('content_topic')
                        ->whereColumn(
                            'content_topic.content_id',
                            'contents.id'
                        );
                }
            )

            ->latest('published_at')

            ->limit(50)

            ->get()

            ->map(fn ($content) => [

                $content->id,

                str($content->title)
                    ->limit(80),
            ])

            ->toArray();

        $this->newLine();

        $this->info('UNASSIGNED AI CANDIDATES');

        $this->table(
            [
                'ID',
                'Title',
            ],
            $rows
        );
    }

    private function coverage(): void
    {
        $total =
            Content::count();

        $assigned =
            DB::table('content_topic')
                ->distinct('content_id')
                ->count();

        $coverage =
            round(
                ($assigned / max($total, 1))
                * 100,
                2
            );

        $this->newLine();

        $this->info('COVERAGE');

        $this->table(
            ['Metric', 'Value'],
            [
                ['Total Contents', $total],
                ['Assigned', $assigned],
                ['Coverage %', $coverage],
            ]
        );
    }

    private function topicDistribution(): void
    {
        $rows = Topic::query()

            ->withCount('contents')

            ->orderByDesc('contents_count')

            ->get()

            ->map(fn ($topic) => [

                $topic->name,

                $topic->contents_count,
            ])

            ->toArray();

        $this->newLine();

        $this->info('TOPIC DISTRIBUTION');

        $this->table(
            ['Topic', 'Matches'],
            $rows
        );
    }

    private function trendMetrics(): void
    {
        $rows = Trend::query()

            ->with('topic')

            ->orderByDesc('score')

            ->get()

            ->map(fn ($trend) => [

                $trend->topic?->name,

                $trend->growth_rate,

                $trend->velocity,

                $trend->authority_score,

                $trend->score,
            ])

            ->toArray();

        $this->newLine();

        $this->info('TREND METRICS');

        $this->table(
            [
                'Topic',
                'Growth',
                'Velocity',
                'Authority',
                'Score',
            ],
            $rows
        );
    }

    private function opportunities(): void
    {
        $rows = Opportunity::query()

            ->orderByDesc('score')

            ->get()

            ->map(fn ($opportunity) => [

                $opportunity->title,

                $opportunity->score,

                $opportunity->reason,
            ])

            ->toArray();

        $this->newLine();

        $this->info('OPPORTUNITIES');

        $this->table(
            [
                'Topic',
                'Score',
                'Reason',
            ],
            $rows
        );
    }

    private function overlapDistribution(): void
    {
        $rows = DB::table('content_topic')

            ->selectRaw('COUNT(topic_id) as matched_topics')
            ->groupBy('content_id')

            ->get()

            ->groupBy('matched_topics')

            ->map(fn ($items, $count) => [

                $count,

                $items->count(),
            ])

            ->values()
            ->toArray();

        $this->newLine();

        $this->info('OVERLAP DISTRIBUTION');

        $this->table(
            [
                'Topics Per Content',
                'Contents',
            ],
            $rows
        );
    }

    private function unassignedAiCandidatesSummary(): void
    {
        $rows = Content::query()

            ->whereDoesntHave('topics')

            ->where(function ($query) {

                $query

                    ->where('title', 'like', '%ai%')

                    ->orWhere('title', 'like', '%agent%')

                    ->orWhere('title', 'like', '%llm%')

                    ->orWhere('title', 'like', '%model%')

                    ->orWhere('title', 'like', '%reasoning%')

                    ->orWhere('title', 'like', '%multimodal%')

                    ->orWhere('title', 'like', '%voice%')

                    ->orWhere('title', 'like', '%foundation%');
            })

            ->selectRaw('source_id, count(*) as total')

            ->groupBy('source_id')

            ->with('source:id,name')

            ->orderByDesc('total')

            ->limit(20)

            ->get()

            ->map(fn ($row) => [

                $row->source?->name,

                $row->total,
            ])

            ->toArray();

        $this->newLine();

        $this->info('AI GAPS BY SOURCE');

        $this->table(
            ['Source', 'Candidates'],
            $rows
        );
    }

    private function unmatchedKeywordHints(): void
    {
        $words = [];

        Content::query()

            ->whereDoesntHave('topics')

            ->limit(500)

            ->get()

            ->each(function ($content) use (&$words) {

                $text = strtolower(
                    strip_tags(
                        $content->title
                    )
                );

                preg_match_all(
                    '/[a-z0-9\-]{4,}/',
                    $text,
                    $matches
                );

                foreach ($matches[0] as $word) {

                    $words[$word] =
                        ($words[$word] ?? 0) + 1;
                }
            });

        arsort($words);

        $rows =
            collect($words)

                ->take(50)

                ->map(fn ($count, $word) => [

                    $word,

                    $count,
                ])

                ->values()

                ->toArray();

        $this->newLine();

        $this->info('UNMATCHED KEYWORD HINTS');

        $this->table(
            ['Keyword', 'Count'],
            $rows
        );
    }
}
