<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;

use Domains\Topic\Actions\GetTopicsExplorerAction;

new #[Layout('layouts::panel', [
    'title' => 'موضوعات',
])]
class extends Component
{
    #[Computed]
    public function topics()
    {
        return app(
            GetTopicsExplorerAction::class
        )->execute();
    }
};
?>

<div>

    <x-panel.page-header
        title="موضوعات"
        description="اکتشاف و تحلیل موضوعات شناسایی شده"
    />

    <div
        class="
            grid
            gap-6
            md:grid-cols-2
            xl:grid-cols-3
        "
    >

        @foreach(
            $this->topics
            as $topic
        )

            <x-panel.topic-card
                :topic="$topic"
            />

        @endforeach

    </div>

</div>
