<?php

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;

use Domains\Content\Models\Content;
use Domains\Source\Models\Source;

new class extends Component {
    use WithPagination;

    public string $search = '';

    public ?int $sourceFilter = null;

    public array $sortBy = [
        'column' => 'published_at',
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
                'key' => 'source.name',
                'label' => 'Source',
            ],

            [
                'key' => 'title',
                'label' => 'Title',
            ],

            [
                'key' => 'published_at',
                'label' => 'Published',
            ],
        ];
    }

    public function getSourcesProperty(): \Illuminate\Database\Eloquent\Collection
    {
        return Source::query()
            ->orderBy('name')
            ->get();
    }

    public function getMissedBySourceProperty()
    {
        return Content::whereDoesntHave('topics')
            ->selectRaw('source_id, count(*) as missed')
            ->groupBy('source_id')
            ->orderByDesc('missed')
            ->with('source:id,name')
            ->get();
    }

    public function getContentsProperty(): LengthAwarePaginator
    {
        return Content::query()
            ->with('source')
            ->when(
                $this->search,
                fn($query) => $query->where(
                    'title',
                    'like',
                    "%{$this->search}%"
                )
            )
            ->when(
                $this->sourceFilter,
                fn($query) => $query->where(
                    'source_id',
                    $this->sourceFilter
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

    public function updatedSourceFilter(): void
    {
        $this->resetPage();
    }
};

?>

<div class="space-y-6">

    <x-header
        title="Contents"
        subtitle="Collected RSS contents"
        separator
    />

    <div class="grid md:grid-cols-3 gap-4">

        <x-input
            label="Search"
            icon="o-magnifying-glass"
            wire:model.live.debounce.300ms="search"
            placeholder="Search title..."
        />

        <x-select
            label="Source"
            wire:model.live="sourceFilter"
            placeholder="All Sources"
            :options="$this->sources"
            option-label="name"
            option-value="id"
        />

    </div>

    <x-card>

        <x-table
            :headers="$this->headers"
            :rows="$this->contents"
            :sort-by="$sortBy"
            with-pagination
        >

            @scope('cell_source.name', $content)

            <div class="badge badge-primary badge-outline">
                {{ $content->source?->name }}
            </div>

            @endscope

            @scope('cell_title', $content)

            <div class="max-w-xl">


                {{ $content->title }}


            </div>

            @endscope

            @scope('cell_published_at', $content)

            <span class="badge badge-ghost">
                    {{ $content->published_at?->format('Y-m-d H:i') }}
                </span>

            @endscope

            @scope('actions', $content)

            <a
                href="{{ $content->url }}"
                target="_blank"
                class="btn btn-xs btn-primary"
            >
                Open
            </a>

            @endscope

        </x-table>

    </x-card>

    <div class="stats shadow w-full">

        <div class="stat">

            <div class="stat-title">
                Total Contents
            </div>

            <div class="stat-value text-primary">
                {{ number_format(\Domains\Content\Models\Content::count()) }}
            </div>

        </div>

        <div class="stat">

            <div class="stat-title">
                Sources
            </div>

            <div class="stat-value">
                {{ number_format(\Domains\Source\Models\Source::count()) }}
            </div>

        </div>




    </div>
    <div class="stats shadow w-full">

        <div class="stat">
            <div class="stat-title">Total Contents</div>
            <div class="stat-value text-primary">
                {{ number_format(\Domains\Content\Models\Content::count()) }}
            </div>
        </div>

        <div class="stat">
            <div class="stat-title">Sources</div>
            <div class="stat-value">
                {{ number_format(\Domains\Source\Models\Source::count()) }}
            </div>
        </div>

        <div class="stat">
            <div class="stat-title">Unassigned Content</div>
            <div class="stat-value text-warning">
                {{ Content::whereDoesntHave('topics')->count() }}
            </div>
        </div>

    </div>

    {{-- لیست منابع با بیشترین miss --}}
    <x-card title="Missed by Source">
        <ul class="divide-y">
            @forelse($this->missedBySource as $row)
                <li class="flex justify-between py-2">
                    <span>{{ $row->source?->name ?? 'نامشخص' }}</span>
                    <span class="badge badge-warning">{{ $row->missed }} missed</span>
                </li>
            @empty
                <li class="py-2 text-success">همه محتواها تاپیک دارند ✅</li>
            @endforelse
        </ul>
    </x-card>

</div>
