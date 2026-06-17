<?php


use Domains\Topic\Actions\RebuildTopicAction;
use Domains\Topic\Models\Topic;
use Domains\Trend\Models\TrendSnapshot;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Domains\Topic\Actions\RefreshTopicMatchesAction;

new class extends Component {
    public Topic $topic;

    public function mount(
        Topic $topic
    ): void
    {

        $this->topic = $topic;

        $this->loadTopic();
    }

    public function rebuildTopic(
        RebuildTopicAction $action
    ): void
    {

        $action->execute(
            $this->topic
        );

        $this->loadTopic();

    }

    public function refreshMatches(
        RefreshTopicMatchesAction $action
    ): void
    {

        $count = $action->execute(
            $this->topic
        );

        $this->loadTopic();

        session()->flash(
            'success',
            "{$count} contents matched."
        );
    }

    protected function loadTopic(): void
    {
        $this->topic = Topic::query()
            ->with([
                'trend',
            ])
            ->withCount([
                'contents',
                'keywords',
                'clusters',
                'snapshots',
                'opportunities',
            ])
            ->findOrFail(
                $this->topic->id
            );
    }

    public function getHealthProperty(): array
    {
        return [

            'contents' =>
                $this->topic->contents_count,

            'keywords' =>
                $this->topic->keywords_count,

            'clusters' =>
                $this->topic->clusters_count,

            'snapshots' =>
                $this->topic->snapshots_count,

            'opportunities' =>
                $this->topic->opportunities_count,

            'trend_score' =>
                round(
                    $this->topic
                        ->trend?->score ?? 0,
                    2
                ),
            'momentum' => app(
                \Domains\Trend\Services\MomentumService::class
            )->calculate(
                $this->topic->trend?->growth_rate ?? 0,
                $this->topic->trend?->velocity ?? 0
            ),
        ];
    }

    public function getStatisticsProperty(): array
    {
        return [

            'last_content' =>

                $this->topic
                    ->contents()
                    ->max(
                        'published_at'
                    ),

            'last_snapshot' =>

                $this->topic
                    ->snapshots()
                    ->max(
                        'captured_at'
                    ),

            'last_trend' =>

                $this->topic
                    ->trend?->calculated_at,

            'opportunity_score' =>

                round(

                    $this->topic
                        ->opportunities()
                        ->max(
                            'score'
                        ) ?? 0,

                    2
                ),


        ];
    }

    public function getKeywordsProperty(): Collection
    {
        return $this->topic
            ->keywords()
            ->orderByDesc(
                'weight'
            )
            ->get();
    }

    public function getLatestContentsProperty(): Collection
    {
        return $this->topic
            ->contents()
            ->with('source')
            ->latest(
                'published_at'
            )
            ->limit(20)
            ->get();
    }

    public function getClustersProperty(): Collection
    {
        return $this->topic
            ->clusters()
            ->orderByDesc(
                'content_count'
            )
            ->limit(20)
            ->get();
    }

    public function getSnapshotsProperty(): Collection
    {
        return TrendSnapshot::query()
            ->where(
                'topic_id',
                $this->topic->id
            )
            ->latest(
                'captured_at'
            )
            ->limit(30)
            ->get();
    }
};

?>
<div class="space-y-6">

    <x-header
        :title="$topic->name"
        :subtitle="$topic->description"
        separator
    >
        <x-slot:actions>

            <x-button
                label="Edit"
                icon="o-pencil"
                link="/topics/{{ $topic->id }}/edit"
            />

            <x-button
                label="Keywords"
                icon="o-key"
                link="/topics/{{ $topic->id }}/keywords"
            />

            <x-button
                label="Rebuild Topic"
                icon="o-arrow-path"
                wire:click="rebuildTopic"
                spinner
                class="btn-primary"
            />


        </x-slot:actions>

    </x-header>

    {{-- Health Widget --}}

    <div
        class="grid
               grid-cols-2
               lg:grid-cols-6
               gap-4"
    >

        <x-stat
            title="Contents"
            :value="$this->health['contents']"
            icon="o-document-text"
        />

        <x-stat
            title="Keywords"
            :value="$this->health['keywords']"
            icon="o-key"
        />

        <x-stat
            title="Clusters"
            :value="$this->health['clusters']"
            icon="o-squares-2x2"
        />

        <x-stat
            title="Snapshots"
            :value="$this->health['snapshots']"
            icon="o-clock"
        />

        <x-stat
            title="Trend"
            :value="$this->health['trend_score']"
            icon="o-chart-bar"
        />

        <x-stat
            title="Opportunities"
            :value="$this->health['opportunities']"
            icon="o-light-bulb"
        />

        <x-stat
            title="Momentum"
            :value="$this->health['momentum']"
            icon="o-bolt"
        />

    </div>

    {{-- Statistics --}}

    <x-card title="Statistics">

        <div
            class="grid
                   grid-cols-1
                   md:grid-cols-2
                   lg:grid-cols-4
                   gap-4"
        >

            <div>

                <div class="text-sm opacity-60">
                    Last Content
                </div>

                <div class="font-semibold">

                    @if(
                        $this->statistics['last_content']
                    )

                        {{
                            \Carbon\Carbon::parse(
                                $this->statistics['last_content']
                            )->diffForHumans()
                        }}

                    @else

                        -

                    @endif

                </div>

            </div>

            <div>

                <div class="text-sm opacity-60">
                    Last Snapshot
                </div>

                <div class="font-semibold">

                    @if(
                        $this->statistics['last_snapshot']
                    )

                        {{
                            \Carbon\Carbon::parse(
                                $this->statistics['last_snapshot']
                            )->diffForHumans()
                        }}

                    @else

                        -

                    @endif

                </div>

            </div>

            <div>

                <div class="text-sm opacity-60">
                    Last Trend
                </div>

                <div class="font-semibold">

                    @if(
                        $this->statistics['last_trend']
                    )

                        {{
                            \Carbon\Carbon::parse(
                                $this->statistics['last_trend']
                            )->diffForHumans()
                        }}

                    @else

                        -

                    @endif

                </div>

            </div>

            <div>

                <div class="text-sm opacity-60">
                    Opportunity Score
                </div>

                <div class="font-semibold">

                    {{
                        number_format(
                            $this->statistics['opportunity_score'],
                            2
                        )
                    }}

                </div>

            </div>

        </div>

    </x-card>

    {{-- Keywords --}}

    <x-card title="Keywords">

        <div class="flex flex-wrap gap-2">

            @foreach(
                $this->keywords
                as $keyword
            )

                <x-badge
                    :value="$keyword->keyword . ' (' . $keyword->weight . ')'"
                    class="badge-primary"
                />

            @endforeach

        </div>

    </x-card>

    {{-- Clusters --}}

    <x-card title="Top Clusters">

        <div class="space-y-2">

            @forelse(
                $this->clusters
                as $cluster
            )

                <div
                    class="flex justify-between items-center
                           p-3 rounded-lg bg-base-200"
                >

                    <span>
                        {{ $cluster->name }}
                    </span>

                    <x-badge
                        :value="$cluster->content_count"
                        class="badge-primary"
                    />

                </div>

            @empty

                <div class="text-center opacity-60 py-4">
                    No clusters found
                </div>

            @endforelse

        </div>

    </x-card>

    {{-- Latest Contents --}}

    <x-card title="Latest Contents">

        <div class="overflow-x-auto">

            <table class="table">

                <thead>

                <tr>

                    <th>Title</th>
                    <th>Source</th>
                    <th>Published</th>

                </tr>

                </thead>

                <tbody>

                @forelse(
                    $this->latestContents
                    as $content
                )

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
                                class="badge-outline"
                            />

                        </td>

                        <td>

                            @if(
                                $content->published_at
                            )

                                {{
                                    $content->published_at
                                        ->diffForHumans()
                                }}

                            @else

                                -

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="3"
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
