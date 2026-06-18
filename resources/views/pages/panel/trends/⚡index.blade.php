<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;

use Domains\Trend\Actions\GetTopTrendsAction;

new #[Layout('layouts::panel', [
    'title' => 'روندها',
])]
class extends Component
{
    #[Computed]
    public function trends()
    {
        return app(
            GetTopTrendsAction::class
        )->execute();
    }
};

?>

<div>

    <x-panel.page-header
        title="روندها"
        description="روندهای فعال و در حال رشد"
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
            $this->trends
            as $trend
        )

            <x-panel.trend-card
                :trend="$trend"
            />

        @endforeach

    </div>

</div>
