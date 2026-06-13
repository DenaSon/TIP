<?php

use Livewire\Component;
use Domains\Source\Models\Source;
use Domains\Source\Actions\SourceAction;
use Illuminate\Validation\Rule;

new class extends Component
{
    public string $name = '';

    public string $url = '';

    public int $authority_score = 50;

    public ?int $editingId = null;

    protected function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'url' => [
                'required',
                'url',
            ],

            'authority_score' => [
                'required',
                'integer',
                'between:0,100',
            ],
        ];
    }

    public function save(): void
    {
        if ($this->editingId) {
            $this->update();

            return;
        }

        $this->validate();

        app(SourceAction::class)->create([
            'name' => $this->name,
            'type' => Source::TYPE_RSS,
            'status' => Source::STATUS_ACTIVE,
            'authority_score' => $this->authority_score,
            'config' => [
                'url' => $this->url,
            ],
        ]);

        $this->resetForm();
    }

    public function update(): void
    {
        $this->validate();

        $source = Source::findOrFail(
            $this->editingId
        );

        app(SourceAction::class)->update(
            $source,
            [
                'name' => $this->name,
                'type' => $source->type,
                'status' => $source->status,
                'authority_score' => $this->authority_score,
                'config' => [
                    'url' => $this->url,
                ],
            ]
        );

        $this->resetForm();
    }

    public function edit(int $sourceId): void
    {
        $source = Source::findOrFail(
            $sourceId
        );

        $this->editingId = $source->id;

        $this->name = $source->name;

        $this->url = $source->url;

        $this->authority_score =
            $source->authority_score;
    }

    public function toggle(int $sourceId): void
    {
        $source = Source::findOrFail(
            $sourceId
        );

        app(SourceAction::class)
            ->toggleStatus($source);
    }

    public function delete(int $sourceId): void
    {
        $source = Source::findOrFail(
            $sourceId
        );

        app(SourceAction::class)
            ->delete($source);
    }

    public function restore(int $sourceId): void
    {
        $source = Source::withTrashed()
            ->findOrFail($sourceId);

        app(SourceAction::class)
            ->restore($source);
    }

    protected function resetForm(): void
    {
        $this->reset([
            'editingId',
            'name',
            'url',
        ]);

        $this->authority_score = 50;
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

    <x-card
        :title="$editingId
        ? 'Edit Source'
        : 'Create Source'"
    >

        <div class="grid gap-4">

            <x-input
                label="Name"
                wire:model="name"
            />

            <x-input
                label="RSS URL"
                wire:model="url"
            />

            <x-input
                label="Authority score"
                min="0" max="100"
                wire:model="authority_score"
            />

            <x-button
                wire:click="save"
                :label="$editingId ? 'Update Source' : 'Create Source'"
                class="btn-primary"
            />

            @if($editingId)

                <x-button
                    label="Cancel"
                    link="{{ route('sources.index') }}"
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
                    <th>Authority</th>
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
                            {{ $source->authority_score }}
                        </td>
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
