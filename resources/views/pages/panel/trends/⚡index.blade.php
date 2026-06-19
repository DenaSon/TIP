<?php

use App\Support\Concerns\HasInfiniteScroll;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;

use Domains\Trend\Models\Trend;
use Domains\Trend\Actions\GetTopTrendsAction;

new #[Layout('layouts::panel', [
    'title' => 'روندها',
])]
class extends Component {
    use HasInfiniteScroll;

    public function mount(): void
    {
        $this->mountHasInfiniteScroll();
    }

    protected function totalItemsCount(): int
    {
        return Trend::count();
    }


    #[Computed]
    public function trends()
    {
        return app(
            GetTopTrendsAction::class
        )->execute(
            limit: $this->limit
        );
    }
};

?>

<div>

    @php

        $trends =
            $this->trends;

        $topTrend =
            $trends->first();

    @endphp

    @if($trends->isNotEmpty())

        {{-- Hero --}}
        <div
            class="
                card
                bg-base-100
                border
                border-base-300
                shadow-sm
                mb-6
            "
        >

            <div class="card-body">

                <div
                    class="
                        flex
                        flex-col
                        lg:flex-row
                        lg:items-center
                        lg:justify-between
                        gap-4
                    "
                >

                    <div>

                        <div
                            class="
                                badge
                                badge-outline
                                badge-primary
                                mb-3
                            "
                        >
                            داغ‌ترین روند فعلی
                        </div>

                        <h2
                            class="
                                text-3xl
                                font-black
                            "
                        >
                            {{ $topTrend->topic->name }}
                        </h2>

                        <p
                            class="
                                text-sm
                                text-base-content/60
                                mt-2
                            "
                        >
                            موضوعی که بیشترین رشد و توجه را در داده‌های اخیر دریافت کرده است.
                        </p>

                    </div>

                    <div
                        class="
                            flex
                            flex-wrap
                            gap-2
                        "
                    >

                        <x-badge
                            :value="
                                round(
                                    $topTrend->score
                                ) . ' امتیاز'
                            "
                            icon="o-chart-bar"
                            class="badge-primary"
                        />

                        <x-badge
                            :value="
                                round(
                                    $topTrend->growth_rate
                                ) . '% رشد'
                            "
                            icon="o-arrow-trending-up"
                            class="badge-success"
                        />

                        <x-badge
                            :value="
                                $trends->count()
                                . ' روند'
                            "
                            icon="o-fire"
                            class="badge-outline"
                        />

                    </div>

                </div>

            </div>

        </div>

        {{-- Grid --}}
        <div
            class="
                grid
                gap-6
                md:grid-cols-2
                xl:grid-cols-3
            "
        >

            @foreach(
                $trends as $trend
            )

                <x-panel.trend-card
                    :trend="$trend"
                />

            @endforeach

        </div>

        {{-- Infinite Scroll --}}
        @if($hasMore)

            <div
                wire:intersect.margin.300px="loadMore"
                class="
                    flex
                    justify-center
                    py-10
                "
            >

                <span
                    class="
                        loading
                        loading-spinner
                        loading-md
                    "
                ></span>

            </div>

        @else

            <div
                class="
                    text-center
                    py-8
                    text-sm
                    text-base-content/50
                "
            >

                همه روندها نمایش داده شدند

            </div>

        @endif

    @else

        <x-panel.empty-state
            title="روندی پیدا نشد"
            description="هنوز روند فعالی برای نمایش وجود ندارد."
            icon="o-fire"
        />

    @endif

</div>
