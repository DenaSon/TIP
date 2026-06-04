<?php

use Livewire\Attributes\Layout;

use Livewire\Component;
use Domains\Source\Models\Source;
use Domains\Source\Actions\SourceAction;

new
class extends Component {

    public string $name = '';

    public string $url = '';

    public ?int $editingId = null;

    public function save(): void
    {
        if ($this->editingId) {
            $this->update();

            return;
        }

        app(SourceAction::class)->create([
            'name' => $this->name,
            'type' => Source::TYPE_RSS,
            'status' => Source::STATUS_ACTIVE,
            'config' => [
                'url' => $this->url,
            ],
        ]);

        $this->resetForm();
    }


    public function toggle(int $sourceId): void
    {
        $source = Source::findOrFail($sourceId);

        app(SourceAction::class)->toggleStatus($source);
    }

    public function edit(int $sourceId): void
    {
        $source = Source::findOrFail($sourceId);

        $this->editingId = $source->id;

        $this->name = $source->name;
        $this->url = $source->url;
    }

    public function update(): void
    {
        $this->validate([
            'name' => ['required', 'string'],
            'url' => ['required', 'url'],
        ]);

        $source = Source::findOrFail($this->editingId);

        app(SourceAction::class)->update(
            $source,
            [
                'name' => $this->name,
                'type' => $source->type,
                'status' => $source->status,
                'config' => [
                    'url' => $this->url,
                ],
            ]
        );

        $this->resetForm();
    }

    protected function resetForm(): void
    {
        $this->reset([
            'editingId',
            'name',
            'url',
        ]);
    }

    public function delete(int $sourceId): void
    {
        $source = Source::findOrFail($sourceId);

        app(SourceAction::class)->delete($source);
    }


    public function restore(int $sourceId): void
    {
        $source = Source::withTrashed()
            ->findOrFail($sourceId);

        app(SourceAction::class)->restore($source);
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

    <x-card title="Create Source"    :title="$editingId ? 'Edit Source' : 'Create Source'">

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
                wire:click="save"
                :label="$editingId ? 'Update Source' : 'Create Source'"
                class="btn-primary"
            />

            @if($editingId)

                <x-button
                    label="Cancel"
                    link="{{ route('source.index') }}"
                />

            @endif

        </div>

    </x-card>

    <x-card title="Sources List" >

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

                            <x-button spinner class="btn btn-xs btn-outline {{ $source->isActive() ? 'btn-warning ' : 'btn-success ' }}"
                                wire:click="toggle({{ $source->id }})"
                                size="sm"
                                label="{{ $source->isActive() ? 'Deactivate' : 'Activate' }}"
                            />



                            <x-button spinner
                                label="Delete"
                                icon="o-trash"
                                wire:click="delete({{ $source->id }})"
                                wire:confirm="Delete this source?"
                                class="btn-error btn-xs btn-outline"
                            />

                            <x-button
                                label="Edit"
                                icon="o-pencil"
                                wire:click="edit({{ $source->id }})"
                                class="btn-info btn-xs btn-outline"
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
