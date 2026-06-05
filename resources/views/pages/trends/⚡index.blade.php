<?php

use Livewire\Component;
use Livewire\WithPagination;

use Domains\Trend\Models\Trend;

new class extends Component
{
    use WithPagination;

    public string $search = '';

    public array $sortBy = [
        'column' => 'score',
        'direction' => 'desc',
    ];

    public function getHeadersProperty(): array
    {
        return [

            [
                'key' => 'topic.name',
                'label' => 'Topic',
            ],

            [
                'key' => 'score',
                'label' => 'Score',
            ],

            [
                'key' => 'contents_count',
                'label' => 'Contents',
            ],

            [
                'key' => 'calculated_at',
                'label' => 'Calculated',
            ],
        ];
    }

    public function getTrendsProperty()
    {
        return Trend::query()

            ->with('topic')

            ->whereHas('topic', function ($query) {

                $query->when(
                    $this->search,
                    fn ($q) => $q->where(
                        'name',
                        'like',
                        "%{$this->search}%"
                    )
                );
            })

            ->orderBy(
                $this->sortBy['column'],
                $this->sortBy['direction']
            )

            ->paginate(20);
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }
};

?>

<div class="space-y-6">

    <x-header
        title="Trends"
        subtitle="Calculated topic trends"
        separator
    />

    <x-input
        label="Search"
        icon="o-magnifying-glass"
        wire:model.live.debounce.300ms="search"
        placeholder="Search topic..."
    />

    <x-card>

        <x-table
            :headers="$this->headers"
            :rows="$this->trends"
            :sort-by="$sortBy"
            with-pagination
        >

            @scope('cell_topic.name', $trend)

            <x-badge
                :value="$trend->topic?->name"
                class="badge-primary"
            />

            @endscope

            @scope('cell_score', $trend)

            <div class="badge badge-success">
                {{ number_format($trend->score) }}
            </div>

            @endscope

            @scope('cell_contents_count', $trend)

            <div class="badge badge-outline">
                {{ number_format(
                    $trend->contents_count
                ) }}
            </div>

            @endscope

            @scope('cell_calculated_at', $trend)

            <span class="text-sm opacity-70">

                    {{
                        $trend->calculated_at
                            ?->diffForHumans()
                    }}

                </span>

            @endscope

        </x-table>

    </x-card>

</div>
