<?php

use Domains\Topic\Models\Topic;
use Illuminate\Validation\Rule;
use Livewire\Component;

new class extends Component
{
    public Topic $topic;

    public string $name = '';

    public string $description = '';

    public bool $is_active = true;

    public function mount(
        Topic $topic
    ): void {

        $this->topic = $topic;

        $this->name =
            $topic->name;

        $this->description =
            $topic->description ?? '';

        $this->is_active =
            $topic->is_active;
    }

    protected function rules(): array
    {
        return [

            'name' => [

                'required',
                'string',
                'max:255',

                Rule::unique(
                    'topics',
                    'name'
                )->ignore(
                    $this->topic->id
                ),
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

    public function update(): void
    {
        $this->validate();

        $this->topic->update([

            'name' => $this->name,

            'slug' => str(
                $this->name
            )->slug(),

            'description' =>
                $this->description,

            'is_active' =>
                $this->is_active,

        ]);

        session()->flash(
            'success',
            'Topic updated successfully.'
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
        title="Edit Topic"
        :subtitle="$topic->name"
        separator
    />

    <x-card>

        <div class="grid gap-4">

            <x-input
                label="Topic Name"
                wire:model="name"
            />

            <x-textarea
                label="Description"
                wire:model="description"
                rows="4"
            />

            <x-toggle
                label="Active"
                wire:model="is_active"
            />

            <div class="flex gap-2">

                <x-button
                    label="Update Topic"
                    icon="o-check"
                    wire:click="update"
                    class="btn-primary"
                />

                <x-button
                    label="Keywords"
                    icon="o-key"
                    link="/topics/{{ $topic->id }}/keywords"
                    class="btn-outline"
                />

                <x-button
                    label="Cancel"
                    link="/topics"
                />

            </div>

        </div>

    </x-card>

</div>
