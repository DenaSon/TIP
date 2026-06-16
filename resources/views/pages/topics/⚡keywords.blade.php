<?php

use App\Domains\Topic\Models\TopicKeyword;
use Domains\Topic\Models\Topic;
use Livewire\Component;

new class extends Component
{
    public Topic $topic;

    public string $keyword = '';

    public int $weight = 10;

    public function mount(
        Topic $topic
    ): void {
        $this->topic = $topic;
    }

    protected function rules(): array
    {
        return [

            'keyword' => [
                'required',
                'string',
                'max:255',
            ],

            'weight' => [
                'required',
                'integer',
                'between:1,100',
            ],

        ];
    }

    public function addKeyword(): void
    {
        $this->validate();

        TopicKeyword::query()
            ->firstOrCreate(
                [
                    'topic_id' => $this->topic->id,
                    'keyword' => trim(
                        $this->keyword
                    ),
                ],
                [
                    'weight' => $this->weight,
                ]
            );

        $this->reset([
            'keyword',
            'weight',
        ]);

        $this->weight = 10;
    }

    public function updateWeight(
        int $keywordId,
        int $weight
    ): void {

        TopicKeyword::query()

            ->where('id', $keywordId)

            ->update([
                'weight' => $weight,
            ]);
    }

    public function deleteKeyword(
        int $keywordId
    ): void {

        TopicKeyword::query()

            ->where('id', $keywordId)

            ->delete();
    }

    public function getKeywordsProperty()
    {
        return $this->topic

            ->keywords()

            ->orderByDesc('weight')

            ->orderBy('keyword')

            ->get();
    }
};

?>

<div class="space-y-6">

    <x-header
        title="Topic Keywords"
        :subtitle="$topic->name"
        separator
    />

    <x-card>

        <div class="grid md:grid-cols-3 gap-4">

            <x-input
                label="Keyword"
                wire:model="keyword"
                placeholder="e.g. laravel"
            />

            <x-input
                type="number"
                label="Weight"
                min="1"
                max="100"
                wire:model="weight"
            />

            <div class="flex items-end">

                <x-button
                    label="Add Keyword"
                    icon="o-plus"
                    wire:click="addKeyword"
                    class="btn-primary w-full"
                />

            </div>

        </div>

    </x-card>

    <x-card>

        <div class="flex justify-between items-center mb-4">

            <div class="text-sm opacity-70">

                Total Keywords:
                {{ $this->keywords->count() }}

            </div>

        </div>

        <div class="overflow-x-auto">

            <table class="table">

                <thead>

                <tr>

                    <th>Keyword</th>

                    <th width="180">
                        Weight
                    </th>

                    <th width="120">
                        Actions
                    </th>

                </tr>

                </thead>

                <tbody>

                @forelse(
                    $this->keywords
                    as $item
                )

                    <tr>

                        <td>

                            <span
                                class="font-medium"
                            >
                                {{ $item->keyword }}
                            </span>

                        </td>

                        <td>

                            <input
                                type="number"
                                min="1"
                                max="100"
                                value="{{ $item->weight }}"
                                class="input input-bordered input-sm w-24"
                                wire:change="
                                    updateWeight(
                                        {{ $item->id }},
                                        $event.target.value
                                    )
                                "
                            >

                        </td>

                        <td>

                            <x-button
                                icon="o-trash"
                                class="btn-error btn-xs"
                                wire:click="
                                    deleteKeyword(
                                        {{ $item->id }}
                                    )
                                "
                                wire:confirm="
                                    Delete keyword?
                                "
                            />

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="3"
                            class="text-center py-8"
                        >

                            No keywords found

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </x-card>

</div>

