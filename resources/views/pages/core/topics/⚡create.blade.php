<?php

use Domains\Topic\Models\Topic;
use Illuminate\Validation\Rule;
use Livewire\Component;

new class extends Component
{
    public string $name = '';

    public string $description = '';

    public bool $is_active = true;

    protected function rules(): array
    {
        return [

            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('topics', 'name'),
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'is_active' => [
                'boolean',
            ],

        ];
    }

    public function save(): void
    {
        $this->validate();

        Topic::query()
            ->create([

                'name' => $this->name,

                'slug' => str($this->name)
                    ->slug(),

                'description' =>
                    $this->description,

                'is_active' =>
                    $this->is_active,

            ]);

        session()->flash(
            'success',
            'Topic created successfully.'
        );

        $this->redirect(
            '/topics',
            navigate: true
        );
    }
};

?>

<div class="space-y-6">

    <x-header
        title="Create Topic"
        subtitle="Create a new topic for content classification"
        separator
    />

    <x-card>

        <div class="grid gap-4">

            <x-input
                label="Topic Name"
                wire:model="name"
                placeholder="e.g. Laravel"
            />

            <x-textarea
                label="Description"
                wire:model="description"
                rows="4"
                placeholder="Optional description..."
            />

            <x-toggle
                label="Active"
                wire:model="is_active"
            />

            <div class="flex gap-2">

                <x-button
                    label="Create Topic"
                    icon="o-check"
                    wire:click="save"
                    class="btn-primary"
                />

                <x-button
                    label="Cancel"
                    link="/topics"
                />

            </div>

        </div>

    </x-card>

</div>

