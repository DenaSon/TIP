<?php

use Livewire\Component;
use Livewire\WithPagination;

use Domains\Cluster\Models\Cluster;

new class extends Component
{
    use WithPagination;

    public string $search = '';

    public array $sortBy = [
        'column' => 'content_count',
        'direction' => 'desc',
    ];

    public function getHeadersProperty(): array
    {
        return [

            [
                'key' => 'id',
                'label' => '#',
            ],

            [
                'key' => 'name',
                'label' => 'Cluster',
            ],

            [
                'key' => 'content_count',
                'label' => 'Contents',
            ],

            [
                'key' => 'last_content_at',
                'label' => 'Last Content',
            ],
        ];
    }

    public function getClustersProperty()
    {
        return Cluster::query()

            ->with('topic')

            ->when(
                $this->search,
                fn ($query) => $query->where(
                    'name',
                    'like',
                    "%{$this->search}%"
                )
            )

            ->orderBy(
                $this->sortBy['column'],
                $this->sortBy['direction']
            )

            ->paginate(25);
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }
};

?>

<div class="space-y-6">

    <x-header
        title="Clusters"
        subtitle="Grouped contents by topic"
        separator
    />

    <div class="grid md:grid-cols-2 gap-4">

        <x-input
            label="Search"
            icon="o-magnifying-glass"
            wire:model.live.debounce.300ms="search"
            placeholder="Search cluster..."
        />

    </div>

    <x-card>

        <x-table
            :headers="$this->headers"
            :rows="$this->clusters"
            :sort-by="$sortBy"
            with-pagination
        >

            @scope('cell_name', $cluster)

            <div class="font-semibold">
                {{ $cluster->name }}
            </div>

            @endscope

            @scope('cell_content_count', $cluster)

            <span class="badge badge-success badge-outline">

                    {{ number_format($cluster->content_count) }}

                </span>

            @endscope

            @scope('cell_last_content_at', $cluster)

            <span class="badge badge-ghost">

                    {{ $cluster->last_content_at?->format('Y-m-d H:i') }}

                </span>

            @endscope

            @scope('actions', $cluster)

{{--            <span--}}
{{--                class="badge badge-primary badge-outline"--}}
{{--            >--}}
{{--                    {{ $cluster->topic?->name }}--}}
{{--                </span>--}}

            @endscope

        </x-table>

    </x-card>

    <div class="stats shadow w-full">

        <div class="stat">

            <div class="stat-title">
                Total Clusters
            </div>

            <div class="stat-value text-primary">

                {{
                    number_format(
                        \Domains\Cluster\Models\Cluster::count()
                    )
                }}

            </div>

        </div>

        <div class="stat">

            <div class="stat-title">
                Total Relations
            </div>

            <div class="stat-value text-success">

                {{
                    number_format(
                        DB::table(
                            'cluster_content'
                        )->count()
                    )
                }}

            </div>

        </div>

    </div>

</div>
