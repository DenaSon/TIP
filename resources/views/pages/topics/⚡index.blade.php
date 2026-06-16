<?php

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;

use Domains\Topic\Models\Topic;

new class extends Component {
    use WithPagination;

    public string $search = '';
    public string $status = 'all';

    public array $sortBy = [
        'column' => 'contents_count',
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
                'label' => 'Topic',
            ],

            [
                'key' => 'contents_count',
                'label' => 'Contents',
            ],

            [
                'key' => 'is_active',
                'label' => 'Status',
            ],
            [
                'key' => 'keywords_count',
                'label' => 'Keywords',
            ],

            [
                'key' => 'actions',
                'label' => '',
            ]

        ];
    }

    public function getTopicsProperty(): LengthAwarePaginator
    {
        return Topic::query()

            ->withCount([
                'contents',
                'keywords',
            ])

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
            ->when(
                $this->status === 'active',
                fn ($q) => $q->where('is_active', true)
            )

            ->when(
                $this->status === 'inactive',
                fn ($q) => $q->where('is_active', false)
            )

            ->paginate(20);
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function toggle(
        int $topicId
    ): void {

        $topic = Topic::findOrFail(
            $topicId
        );

        $topic->update([
            'is_active' => ! $topic->is_active,
        ]);
    }
};

?>

<div class="space-y-6">

    <x-header
        title="Topics"
        subtitle="Detected topics from contents"
        separator
    />

    <x-button
        label="Create Topic"
        icon="o-plus"
        link="/topics/create"
        class="btn-primary"
    />

    <x-input
        label="Search"
        icon="o-magnifying-glass"
        wire:model.live.debounce.300ms="search"
        placeholder="Search topic..."
    />
    <x-select
        wire:model.live="status"
        :options="[
        ['id' => 'all', 'name' => 'All'],
        ['id' => 'active', 'name' => 'Active'],
        ['id' => 'inactive', 'name' => 'Inactive'],
    ]"
    />

    <x-card>

        <x-table
            :headers="$this->headers"
            :rows="$this->topics"
            :sort-by="$sortBy"
            with-pagination
        >

            @scope('cell_name', $topic)

            <x-button link="{{ route('topics.show',['topic' => $topic->id]) }}"
                :label="$topic->name"
                class="btn btn-link"

            />

            @endscope

            @scope('cell_contents_count', $topic)

            <span class="badge badge-outline">
                    {{ $topic->contents_count }}
                </span>

            @endscope

            @scope('cell_is_active', $topic)

            @if($topic->is_active)

                <span
                    class="badge badge-success"
                >
                        Active
                    </span>

            @else

                <span
                    class="badge badge-error"
                >
                        Disabled
                    </span>

            @endif

            @endscope
            @scope('cell_keywords_count', $topic)

            <span class="badge badge-secondary">
    {{ $topic->keywords_count }}
</span>

            @endscope

            @scope('cell_actions', $topic)

            <div class="flex gap-1">

                <x-button
                    icon="o-pencil"
                    link="/topics/{{ $topic->id }}/edit"
                    class="btn-xs btn-outline"
                />

                <x-button
                    icon="o-key"
                    link="/topics/{{ $topic->id }}/keywords"
                    class="btn-xs btn-outline"
                />

                <x-button
                    title="Active/Deactivate"
                    wire:click="toggle({{ $topic->id }})"
                    icon="{{ $topic->is_active ? 'o-pause' : 'o-play' }}"
                    class="btn-xs {{ $topic->is_active ? 'btn-warning' : 'btn-success' }}"
                />

            </div>

            @endscope

        </x-table>

    </x-card>

</div>
