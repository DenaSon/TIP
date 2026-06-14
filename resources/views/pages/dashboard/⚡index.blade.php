<?php

use Domains\Cluster\Models\Cluster;
use Domains\Content\Models\Content;
use Domains\Source\Models\Source;
use Domains\Topic\Models\Topic;
use Domains\Trend\Models\Trend;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

new class extends Component
{
    public function getStatsProperty(): array
    {
        $topTrend = Trend::query()
            ->with('topic')
            ->orderByDesc('score')
            ->first();

        return [
            'sources' => Source::query()->count(),

            'contents' => Content::query()->count(),

            'topics' => Topic::query()->count(),

            'trends' => Trend::query()->count(),

            'top_trend' => $topTrend?->topic?->name,

            'top_trend_score' => $topTrend?->score ?? 0,
        ];
    }

    public function getMonitoringProperty(): array
    {
        return [

            'last_content' => Content::query()
                ->max('published_at'),

            'last_trend' => Trend::query()
                ->latest('calculated_at')
                ->value('calculated_at'),

            'last_crawl' => Source::query()
                ->max('last_crawled_at'),

            'active_sources' => Source::query()
                ->where(
                    'status',
                    Source::STATUS_ACTIVE
                )
                ->count(),
        ];
    }

    public function getTopTopicsProperty(): Collection
    {
        return Topic::query()

            ->withCount('contents')

            ->orderByDesc('contents_count')

            ->limit(10)

            ->get();
    }

    public function getTopTrendsProperty(): Collection
    {
        return Trend::query()

            ->with('topic')

            ->orderByDesc('score')

            ->limit(10)

            ->get();
    }

    public function getTopClustersProperty(): Collection
    {
        return Cluster::query()

            ->with('topic')

            ->orderByDesc('content_count')

            ->limit(10)

            ->get();
    }

    public function getLatestContentsProperty(): Collection
    {
        return Content::query()

            ->with([
                'source',
                'topics',
            ])

            ->latest('published_at')

            ->limit(10)

            ->get();
    }

    public function getMaxTopicCountProperty(): int
    {
        return max(
            (int) $this->topTopics->max(
                'contents_count'
            ),
            1
        );
    }

    public function getMaxTrendScoreProperty(): float
    {
        return max(
            (float) $this->topTrends->max(
                'score'
            ),
            1
        );
    }
};
?>


<div class="space-y-6" wire:poll.30s>

    <x-header
        title="TIP Dashboard"
        subtitle="Monitor trends, topics and content opportunities"
        separator
    />

    {{-- Stats --}}
    {{-- Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">

        <x-stat
            title="Sources"
            :value="number_format($this->stats['sources'])"
            icon="o-rss"
            description="Registered sources"
            class="shadow"
        />

        <x-stat
            title="Contents"
            :value="number_format($this->stats['contents'])"
            icon="o-document-text"
            description="Collected contents"
            class="shadow"
        />

        <x-stat
            title="Topics"
            :value="number_format($this->stats['topics'])"
            icon="o-tag"
            description="Detected topics"
            class="shadow"
        />

        <x-stat
            title="Trends"
            :value="number_format($this->stats['trends'])"
            icon="o-chart-bar"
            description="Calculated trends"
            class="shadow"
        />

        <x-stat
            title="Top Trend Score"
            :value="number_format($this->stats['top_trend_score'], 1)"
            icon="o-fire"
            description="{{ $this->stats['top_trend'] ?? 'No trend' }}"
            class="shadow"
        />

    </div>

    <x-card
        title="Current Hottest Trend"
        class="shadow-lg"
    >

        <div class="flex items-center justify-between">

            <div>

                <div class="text-2xl font-bold">

                    {{ $this->stats['top_trend'] ?? 'No trend available' }}

                </div>

                <div class="opacity-70 mt-1">

                    Highest trend score in the system

                </div>

            </div>

            <x-badge
                :value="'Score: ' . number_format($this->stats['top_trend_score'], 1)"
                class="badge-success badge-lg"
            />

        </div>

    </x-card>
    {{-- Health --}}
    <x-card
        title="Pipeline Monitoring"
        class="shadow-lg"
    >

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

            <div>

                <div class="text-sm opacity-60">
                    Active Sources
                </div>

                <div class="text-2xl font-bold">
                    {{ $this->monitoring['active_sources'] }}
                </div>

            </div>

            <div>

                <div class="text-sm opacity-60">
                    Last Crawl
                </div>

                <div class="font-semibold">

                    @if($this->monitoring['last_crawl'])

                        {{
                            \Carbon\Carbon::parse(
                                $this->monitoring['last_crawl']
                            )->diffForHumans()
                        }}

                    @else

                        Never

                    @endif

                </div>

            </div>

            <div>

                <div class="text-sm opacity-60">
                    Last Content
                </div>

                <div class="font-semibold">

                    @if($this->monitoring['last_content'])

                        {{
                            \Carbon\Carbon::parse(
                                $this->monitoring['last_content']
                            )->diffForHumans()
                        }}

                    @else

                        No content

                    @endif

                </div>

            </div>

            <div>

                <div class="text-sm opacity-60">
                    Last Trend Calculation
                </div>

                <div class="font-semibold">

                    @if($this->monitoring['last_trend'])

                        {{
                            \Carbon\Carbon::parse(
                                $this->monitoring['last_trend']
                            )->diffForHumans()
                        }}

                    @else

                        Not calculated

                    @endif

                </div>

            </div>

        </div>

    </x-card>

    {{-- Analytics --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Topics --}}
        <x-card
            title="Top Topics"
            class="shadow-lg"
        >

            <div class="space-y-3">

                @foreach($this->topTopics as $topic)

                    <div
                        class="p-3 rounded-xl bg-base-200"
                    >

                        <div
                            class="flex justify-between items-center mb-2"
                        >

                            <span
                                class="font-semibold"
                            >
                                {{ $topic->name }}
                            </span>

                            <x-badge
                                :value="$topic->contents_count . ' contents'"
                                class="badge-primary"
                            />

                        </div>

                        <progress
                            class="progress progress-primary w-full"
                            value="{{ $topic->contents_count }}"
                            max="{{ $this->maxTopicCount }}"
                        ></progress>

                    </div>

                @endforeach

            </div>

        </x-card>

        {{-- Trends --}}
        <x-card
            title="Top Trends"
            class="shadow-lg"
        >

            <div class="space-y-3">

                @foreach($this->topTrends as $trend)

                    <div
                        class="p-3 rounded-xl bg-base-200"
                    >

                        <div
                            class="flex justify-between items-center mb-2"
                        >

                            <span
                                class="font-semibold"
                            >
                                {{ $trend->topic?->name }}
                            </span>

                            <x-badge
                                :value="'Score: ' . number_format($trend->score)"
                                class="badge-success"
                            />

                        </div>

                        <progress
                            class="progress progress-success w-full"
                            value="{{ $trend->score }}"
                            max="{{ $this->maxTrendScore }}"
                        ></progress>

                    </div>

                @endforeach

            </div>

        </x-card>

        <x-card
            title="Top Clusters"
            class="shadow-lg"
        >

            <div class="space-y-3">

                @foreach($this->topClusters as $cluster)

                    <div
                        class="p-3 rounded-xl bg-base-200"
                    >

                        <div
                            class="flex justify-between items-center"
                        >

                            <div>

                                <div class="font-semibold">
                                    {{ $cluster->name }}
                                </div>

                                <div class="text-xs opacity-70">
                                    {{ $cluster->topic?->name }}
                                </div>

                            </div>

                            <x-badge
                                :value="$cluster->content_count . ' contents'"
                                class="badge-primary"
                            />

                        </div>

                    </div>

                @endforeach

            </div>

        </x-card>

    </div>

    <x-card
        title="Latest Collected Contents"
        class="shadow-lg"
    >

        <div class="overflow-x-auto">

            <table class="table table-zebra">

                <thead>

                <tr>
                    <th>Title</th>
                    <th>Source</th>
                    <th>Topics</th>
                    <th>Published</th>
                </tr>

                </thead>

                <tbody>

                @forelse($this->latestContents as $content)

                    <tr>

                        <td>

                            <div class="max-w-xl">

                                <div
                                    class="font-medium line-clamp-2"
                                >
                                    {{ $content->title }}
                                </div>

                            </div>

                        </td>

                        <td>

                            <x-badge
                                :value="$content->source?->name"
                                class="badge-primary"
                            />

                        </td>

                        <td>

                            <div
                                class="flex flex-wrap gap-1"
                            >

                                @forelse(
                                    $content->topics->take(3)
                                    as $topic
                                )

                                    <x-badge
                                        :value="$topic->name"
                                        class="badge-outline badge-sm"
                                    />

                                @empty

                                    <span
                                        class="text-xs opacity-50"
                                    >
                                    -
                                </span>

                                @endforelse

                            </div>

                        </td>

                        <td>

                        <span
                            class="text-sm opacity-70"
                        >

                            @if($content->published_at)

                                {{
                                    \Carbon\Carbon::parse(
                                        $content->published_at
                                    )->diffForHumans()
                                }}

                            @else

                                -

                            @endif

                        </span>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="4"
                            class="text-center py-8"
                        >

                            No contents found

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </x-card>



</div>
