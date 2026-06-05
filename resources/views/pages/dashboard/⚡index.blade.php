<?php

use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

use Domains\Source\Models\Source;
use Domains\Content\Models\Content;
use Domains\Topic\Models\Topic;
use Domains\Trend\Models\Trend;

new class extends Component {

    public function getStatsProperty(): array
    {
        return [
            'sources' => Source::count(),
            'contents' => Content::count(),
            'topics' => Topic::count(),
            'trends' => Trend::count(),
        ];
    }

    public function getMonitoringProperty(): array
    {
        return [

            'last_content' => Content::query()
                ->latest()
                ->value('created_at'),

            'last_trend' => Trend::query()
                ->latest('updated_at')
                ->value('updated_at'),

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

    public function getHealthProperty(): array
    {
        return [
            'active_sources' => Source::query()
                ->where('status', Source::STATUS_ACTIVE)
                ->count(),

            'last_crawl' => Source::query()
                ->max('last_crawled_at'),

            'latest_content' => Content::query()
                ->latest()
                ->value('created_at'),
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

    public function getLatestContentsProperty(): Collection
    {
        return Content::query()
            ->with([
                'source',
                'topics',
            ])
            ->latest()
            ->limit(10)
            ->get();
    }

    public function getMaxTopicCountProperty(): int
    {
        return max(
            (int) $this->topTopics->max('contents_count'),
            1
        );
    }

    public function getMaxTrendScoreProperty(): int
    {
        return max(
            (int) $this->topTrends->max('score'),
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
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

        <x-stat
            title="Sources"
            :value="number_format($this->stats['sources'])"
            icon="o-rss"
            description="Active feeds"
            class="shadow"
        />

        <x-stat
            title="Contents"
            :value="number_format($this->stats['contents'])"
            icon="o-document-text"
            description="Collected articles"
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

    </div>

    {{-- Health --}}
    <x-card
        title="System Health"
        class="shadow-lg"
    >

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div>
                <div class="text-sm opacity-60">
                    Active Sources
                </div>

                <div class="text-2xl font-bold">
                    {{ $this->health['active_sources'] }}
                </div>
            </div>

            <div>
                <div class="text-sm opacity-60">
                    Last Crawl
                </div>

                <div class="text-lg font-semibold">

                    @if($this->health['last_crawl'])
                        {{ \Carbon\Carbon::parse(
                            $this->health['last_crawl']
                        )->diffForHumans() }}
                    @else
                        Never
                    @endif

                </div>
            </div>

            <div>
                <div class="text-sm opacity-60">
                    Latest Content
                </div>

                <div class="text-lg font-semibold">

                    @if($this->health['latest_content'])
                        {{ \Carbon\Carbon::parse(
                            $this->health['latest_content']
                        )->diffForHumans() }}
                    @else
                        No content
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

    </div>

    <x-card
        title="Latest Contents"
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

{{--    <x-card--}}
{{--        title="Pipeline Monitoring"--}}
{{--        class="shadow-lg"--}}
{{--    >--}}

{{--        <div--}}
{{--            class="grid grid-cols-1 md:grid-cols-4 gap-4"--}}
{{--        >--}}

{{--            <div--}}
{{--                class="stat bg-base-200 rounded-xl"--}}
{{--            >--}}
{{--                <div class="stat-title">--}}
{{--                    Active Sources--}}
{{--                </div>--}}

{{--                <div class="stat-value text-primary">--}}
{{--                    {{ $this->monitoring['active_sources'] }}--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div--}}
{{--                class="stat bg-base-200 rounded-xl"--}}
{{--            >--}}
{{--                <div class="stat-title">--}}
{{--                    Last Crawl--}}
{{--                </div>--}}

{{--                <div class="stat-desc">--}}

{{--                    {{--}}
{{--                        $this->monitoring['last_crawl']--}}
{{--                            ? \Carbon\Carbon::parse(--}}
{{--                                $this->monitoring['last_crawl']--}}
{{--                            )->diffForHumans()--}}
{{--                            : 'Never'--}}
{{--                    }}--}}

{{--                </div>--}}
{{--            </div>--}}

{{--            <div--}}
{{--                class="stat bg-base-200 rounded-xl"--}}
{{--            >--}}
{{--                <div class="stat-title">--}}
{{--                    Last Content--}}
{{--                </div>--}}

{{--                <div class="stat-desc">--}}

{{--                    {{--}}
{{--                        $this->monitoring['last_content']--}}
{{--                            ? \Carbon\Carbon::parse(--}}
{{--                                $this->monitoring['last_content']--}}
{{--                            )->diffForHumans()--}}
{{--                            : 'Never'--}}
{{--                    }}--}}

{{--                </div>--}}
{{--            </div>--}}

{{--            <div--}}
{{--                class="stat bg-base-200 rounded-xl"--}}
{{--            >--}}
{{--                <div class="stat-title">--}}
{{--                    Last Trend Calc--}}
{{--                </div>--}}

{{--                <div class="stat-desc">--}}

{{--                    {{--}}
{{--                        $this->monitoring['last_trend']--}}
{{--                            ? \Carbon\Carbon::parse(--}}
{{--                                $this->monitoring['last_trend']--}}
{{--                            )->diffForHumans()--}}
{{--                            : 'Never'--}}
{{--                    }}--}}

{{--                </div>--}}
{{--            </div>--}}

{{--        </div>--}}

{{--    </x-card>--}}

</div>
