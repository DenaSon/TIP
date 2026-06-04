<?php

use Livewire\Attributes\Layout;

use Livewire\Component;
use Domains\Source\Models\Source;
use Domains\Source\Actions\SourceAction;

new
class extends Component {

    public string $name = '';

    public string $url = '';

    public function save(): void
    {
        $this->validate([
            'name' => ['required', 'string'],
            'url' => ['required', 'url'],
        ]);

        app(SourceAction::class)->create([
            'name' => $this->name,
            'type' => Source::TYPE_RSS,
            'status' => Source::STATUS_ACTIVE,
            'config' => [
                'url' => $this->url,
            ],
        ]);

        $this->reset([
            'name',
            'url',
        ]);
    }


    public function toggle(int $sourceId): void
    {
        $source = Source::findOrFail($sourceId);

        app(SourceAction::class)->toggleStatus($source);
    }

    public function delete(int $sourceId): void
    {
        $source = Source::findOrFail($sourceId);

        app(SourceAction::class)->delete($source);
    }


};

?>

@php
    $sources = Source::latest()->get();
@endphp

<div class="space-y-6">

    <x-header
        title="Sources"
        subtitle="Manage RSS sources"
    />

    <x-card title="Create Source">

        <div class="grid gap-4">

            <x-input
                label="Name"
                wire:model="name"
            />

            <x-input
                label="RSS URL"
                wire:model="url"
            />

            <x-button
                label="Create Source"
                wire:click="save"
                class="btn-primary"
            />

        </div>

    </x-card>

    <x-card title="Sources List">

        <div class="overflow-x-auto">

            <table class="table">

                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>URL</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody>

                @forelse($sources as $source)

                    <tr>
                        <td>{{ $source->id }}</td>
                        <td>{{ $source->name }}</td>
                        <td>{{ $source->type }}</td>
                        <td>{{ $source->status }}</td>
                        <td>{{ $source->url }}</td>
                        <td>

                            <x-button spinner class="btn btn-xs {{ $source->isActive() ? 'btn-warning ' : 'btn-success ' }}"
                                wire:click="toggle({{ $source->id }})"
                                size="sm"
                                label="{{ $source->isActive() ? 'Deactivate' : 'Activate' }}"
                            />



                            <x-button spinner
                                label="Delete"
                                icon="o-trash"
                                wire:click="delete({{ $source->id }})"
                                wire:confirm="Delete this source?"
                                class="btn-error btn-xs"
                            />



                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="5">
                            No sources found.
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </x-card>

</div>
