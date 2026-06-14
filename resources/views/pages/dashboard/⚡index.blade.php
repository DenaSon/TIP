<?php

use Domains\Cluster\Models\Cluster;
use Domains\Content\Models\Content;
use Domains\Opportunity\Models\Opportunity;
use Domains\Source\Models\Source;
use Domains\Topic\Models\Topic;
use Domains\Trend\Models\Trend;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

new class extends Component {

    public function getTopOpportunitiesProperty(): Collection
    {
        return Opportunity::query()
            ->with([
                'topic',
                'trend',
            ])
            ->orderByDesc('score')
            ->limit(10)
            ->get();
    }

    public function getMaxOpportunityScoreProperty(): float
    {
        return max(
            (float) $this->topOpportunities->max(
                'score'
            ),
            1
        );
    }


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

        $topOpportunity = Opportunity::query()
            ->orderByDesc('score')
            ->first();

    }

    public function getMonitoringProperty(): array
    {
        return [

            // ─────────────────────────────
            // SOURCE LAYER
            // ─────────────────────────────
            'active_sources' => Source::query()
                ->where('status', Source::STATUS_ACTIVE)
                ->count(),

            'total_sources' => Source::count(),

            'last_crawl' => Source::query()
                ->max('last_crawled_at'),

            // ─────────────────────────────
            // CONTENT LAYER
            // ─────────────────────────────
            'total_contents' => Content::count(),

            'last_content' => Content::query()
                ->max('published_at'),

            'content_ingestion_rate_24h' => Content::query()
                ->where('published_at', '>=', now()->subDay())
                ->count(),

            // ─────────────────────────────
            // TOPIC LAYER
            // ─────────────────────────────
            'total_topics' => Topic::count(),

            'new_topics_24h' => Topic::query()
                ->where('created_at', '>=', now()->subDay())
                ->count(),

            // ─────────────────────────────
            // TREND LAYER
            // ─────────────────────────────
            'total_trends' => Trend::count(),

            'last_trend' => Trend::query()
                ->latest('calculated_at')
                ->value('calculated_at'),

            'trends_24h' => Trend::query()
                ->where('calculated_at', '>=', now()->subDay())
                ->count(),

            // ─────────────────────────────
            // SYSTEM HEALTH (NEW - مهم)
            // ─────────────────────────────

            'pipeline_lag_minutes' => $this->calculatePipelineLag(),

            'system_freshness_score' => $this->calculateFreshnessScore(),

            'data_velocity_score' => $this->calculateVelocityScore(),
        ];
    }

    protected function calculatePipelineLag(): ?int
    {
        $lastContent = Content::max('published_at');

        if (! $lastContent) {
            return null;
        }

        return now()->diffInMinutes($lastContent);
    }

    protected function calculateFreshnessScore(): float
    {
        $lastContent = Content::max('published_at');

        if (! $lastContent) {
            return 0;
        }

        $minutes = now()->diffInMinutes($lastContent);

        // 0 = stale, 100 = fresh
        return max(0, 100 - $minutes);
    }

    protected function calculateVelocityScore(): float
    {
        $last24h = Content::where('published_at', '>=', now()->subDay())->count();

        // normalize (simple version)
        return min(100, $last24h / 10);
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
            (int)$this->topTopics->max(
                'contents_count'
            ),
            1
        );
    }

    public function getMaxTrendScoreProperty(): float
    {
        return max(
            (float)$this->topTrends->max(
                'score'
            ),
            1
        );
    }


};
?>


<div class="space-y-6" wire:poll.30s>

    <div class="bg-gradient-to-r from-primary/10 via-base-100 to-base-100 rounded-2xl p-6 border border-base-200 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-base-content">
                    Trend Intelligence Dashboard
                </h1>

                <p class="text-base-content/60 mt-2 max-w-xl">
                    Monitor trends, topics and content opportunities in real-time across all sources.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <div class="inline-grid *:[grid-area:1/1]">
                    <div class="w-3 h-3 rounded-full bg-success opacity-40 animate-ping"></div>
                    <div class="w-3 h-3 rounded-full bg-success"></div>
                </div>

                <div class="flex flex-col leading-tight">
        <span class="text-sm font-semibold text-success">
            System Live
        </span>
                    <span class="text-xs text-base-content/50">
            Real-time processing active
        </span>
                </div>
            </div>


        </div>
    </div>

    <x-hr></x-hr>

    {{-- Stats --}}
    {{-- Stats --}}
    <div class="stats shadow w-full bg-base-100">

        <div class="stat">
            <div class="stat-figure text-primary">
                <svg xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24"
                     class="inline-block h-8 w-8 stroke-current">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6"/>
                </svg>
            </div>
            <div class="stat-title">Sources</div>
            <div class="stat-value text-primary">
                {{ number_format($this->stats['sources']) }}
            </div>
            <div class="stat-desc">Registered data sources</div>
        </div>

        <div class="stat">
            <div class="stat-figure text-secondary">
                <svg xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24"
                     class="inline-block h-8 w-8 stroke-current">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M9 12h6m2 8H7a2 2 0 01-2-2V6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v10a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div class="stat-title">Contents</div>
            <div class="stat-value text-secondary">
                {{ number_format($this->stats['contents']) }}
            </div>
            <div class="stat-desc">Collected items</div>
        </div>

        <div class="stat">
            <div class="stat-figure text-accent">
                <svg xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24"
                     class="inline-block h-8 w-8 stroke-current">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M7 7h10M7 12h10M7 17h10"/>
                </svg>
            </div>
            <div class="stat-title">Topics</div>
            <div class="stat-value text-accent">
                {{ number_format($this->stats['topics']) }}
            </div>
            <div class="stat-desc">Detected clusters</div>
        </div>

        <div class="stat">
            <div class="stat-figure text-info">
                <svg xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24"
                     class="inline-block h-8 w-8 stroke-current">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M3 3v18h18"/>
                </svg>
            </div>
            <div class="stat-title">Trends</div>
            <div class="stat-value text-info">
                {{ number_format($this->stats['trends']) }}
            </div>
            <div class="stat-desc">Calculated trends</div>
        </div>

        <div class="stat">
            <div class="stat-figure text-warning">
                <svg xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24"
                     class="inline-block h-8 w-8 stroke-current">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 8c-1.5-3-6-3-6 2 0 5 6 7 6 7s6-2 6-7c0-5-4.5-5-6-2z"/>
                </svg>
            </div>
            <div class="stat-title">Top Trend Score</div>
            <div class="stat-value text-warning">
                {{ number_format($this->stats['top_trend_score'], 1) }}
            </div>
            <div class="stat-desc">
                {{ $this->stats['top_trend'] ?? 'No trend detected' }}
            </div>
        </div>

    </div>

        <div class="card bg-gradient-to-r from-success/10 via-base-100 to-base-100 border border-base-200 shadow-lg">

            <div class="card-body">

                <div class="flex items-center justify-between">

                    <div>
                        <h2 class="card-title text-lg flex items-center gap-2">
                            🔥 Current Hottest Trend
                        </h2>

                        <p class="text-base-content/60 text-sm mt-1">
                            Highest ranked signal across all sources
                        </p>
                    </div>

                    <div class="badge badge-success badge-lg gap-1">
                        <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                        {{ number_format($this->stats['top_trend_score'], 1) }}
                    </div>

                </div>

                <div class="mt-6">
                    <div class="text-3xl font-bold tracking-tight">
                        {{ $this->stats['top_trend'] ?? 'No trend available' }}
                    </div>

                    <div class="text-sm text-base-content/50 mt-2">
                        This is the strongest signal detected in the system pipeline
                    </div>
                </div>

            </div>

        </div>


    {{-- Health --}}
    <div class="card bg-base-100 border border-base-200 shadow-lg">

        <div class="card-body">

            <div class="flex items-center justify-between mb-6">
                <h2 class="card-title text-lg">
                    Pipeline Monitoring
                </h2>

                <div class="badge badge-info badge-outline">
                    Live System State
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                <!-- Active Sources (KEEP) -->
                <div class="p-4 rounded-xl bg-base-200/40 border border-base-200">


                    <div class="text-xs text-base-content/60">
                        Data Velocity
                    </div>

                    <div class="text-3xl font-bold text-info mt-1">
                        {{ number_format($this->monitoring['data_velocity_score'] ?? 0, 0) }}
                    </div>

                    <div class="text-xs text-base-content/50 mt-1">
                        Processing throughput
                    </div>


                </div>

                <!-- Last Content (KEEP) -->
                <div class="p-4 rounded-xl bg-base-200/40 border border-base-200">
                    <div class="text-xs text-base-content/60">
                        Last Content
                    </div>

                    <div class="text-sm font-semibold mt-1">
                        @if($this->monitoring['last_content'])
                            {{ \Carbon\Carbon::parse($this->monitoring['last_content'])->diffForHumans() }}
                        @else
                            <span class="text-base-content/40">No content</span>
                        @endif
                    </div>

                    <div class="text-xs text-base-content/50 mt-1">
                        Latest ingestion event
                    </div>
                </div>

                <!-- Freshness Score (NEW) -->
                <div class="p-4 rounded-xl bg-base-200/40 border border-base-200">
                    <div class="text-xs text-base-content/60">
                        Freshness Score
                    </div>

                    <div class="text-3xl font-bold text-success mt-1">
                        {{ number_format($this->monitoring['system_freshness_score'] ?? 0, 0) }}
                    </div>

                    <div class="text-xs text-base-content/50 mt-1">
                        Data health (0–100)
                    </div>
                </div>

                <!-- Pipeline Lag (NEW) -->
                <div class="p-4 rounded-xl bg-base-200/40 border border-base-200">
                    <div class="text-xs text-base-content/60">
                        Pipeline Lag
                    </div>

                    <div class="text-3xl font-bold text-warning mt-1">
                        @if($this->monitoring['pipeline_lag_minutes'] !== null)
                            {{ $this->monitoring['pipeline_lag_minutes'] }}m
                        @else
                            <span class="text-base-content/40">N/A</span>
                        @endif
                    </div>

                    <div class="text-xs text-base-content/50 mt-1">
                        Processing delay
                    </div>
                </div>

            </div>

        </div>

    </div>
    {{-- Analytics --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <x-card
            title="Top Opportunities"
            class="shadow-lg"
        >

            <div class="space-y-3">

                @foreach($this->topOpportunities as $opportunity)

                    <div
                        class="p-3 rounded-xl bg-base-200"
                    >

                        <div
                            class="flex justify-between items-center mb-2"
                        >

                    <span
                        class="font-semibold"
                    >
                        {{ $opportunity->title }}
                    </span>

                            <x-badge
                                :value="'Score: ' . number_format(
                            $opportunity->score,
                            1
                        )"
                                class="badge-warning"
                            />

                        </div>

                        <div
                            class="text-xs opacity-70 mb-2"
                        >
                            {{ $opportunity->reason }}
                        </div>

                        <progress
                            class="progress progress-warning w-full"
                            value="{{ $opportunity->score }}"
                            max="{{ $this->maxOpportunityScore }}"
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
