<?php

use Domains\Content\Models\Content;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

new class extends Component
{
    public Content $content;

    public function mount(
        Content $content
    ): void {

        $this->content = $content->load([
            'source',
            'topics',
            'topicMatches.topic',
        ]);
    }

    public function getTopicMatchesProperty(): Collection
    {
        return $this->content

            ->topicMatches()

            ->with('topic')

            ->orderByDesc('score')

            ->get();
    }
};

?>

<div>
    <div class="space-y-6">

        <x-header
            :title="$content->title"
            :subtitle="$content->source?->name"
            separator
        />

    </div>

    <x-card title="Content Information">

        <div
            class="grid
               grid-cols-1
               md:grid-cols-3
               gap-4"
        >

            <div>

                <div class="text-sm opacity-60">
                    Source
                </div>

                <div class="font-semibold">
                    {{ $content->source?->name }}
                </div>

            </div>

            <div>

                <div class="text-sm opacity-60">
                    Published
                </div>

                <div class="font-semibold">
                    {{ $content->published_at?->diffForHumans() }}
                </div>

            </div>

            <div>

                <div class="text-sm opacity-60">
                    Topics
                </div>

                <div>

                    @foreach(
                        $content->topics
                        as $topic
                    )

                        <x-badge
                            :value="$topic->name"
                            class="badge-primary"
                        />

                    @endforeach

                </div>

            </div>

        </div>

    </x-card>
    <x-card
        title="Topic Matching Debugger"
    >
        @forelse(
    $this->topicMatches
    as $match
)

            <div
                class="mb-4
               p-4
               rounded-lg
               bg-base-200"
            >

                <div
                    class="flex
                   justify-between
                   items-center"
                >

                    <div
                        class="font-bold"
                    >
                        {{ $match->topic->name }}
                    </div>

                    <x-badge
                        :value="'Score: ' . $match->score"
                        class="badge-primary"
                    />

                </div>

                <div
                    class="flex
                   flex-wrap
                   gap-2
                   mt-3"
                >

                    @foreach(
                        $match->matched_keywords
                        as $keyword
                    )

                        <x-badge
                            :value="
                        $keyword['keyword']
                        .' ('
                        .$keyword['weight']
                        .')'
                    "
                            class="badge-outline"
                        />

                    @endforeach

                </div>

            </div>

        @empty

            <div
                class="text-center
               opacity-60"
            >

                No topic matches found

            </div>

        @endforelse

    </x-card>

    <x-card
        title="Content Preview"
    >

        <article
            class="prose
               max-w-none"
        >

            {!! $content->content !!}

        </article>

    </x-card>

</div>

