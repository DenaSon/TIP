<?php

use App\Support\Concerns\HasInfiniteScroll;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;

use Domains\Trend\Models\Trend;
use Domains\Opportunity\Actions\GetTopOpportunitiesAction;

new #[Layout('layouts::panel', [
    'title' => 'فرصت‌ها',
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
    public function opportunities()
    {
        return app(
            GetTopOpportunitiesAction::class
        )->execute(
            limit: $this->limit
        );
    }
};

?>


<div>

    @php

        $opportunities =
            $this->opportunities;

        $topOpportunity =
            $opportunities->first();

    @endphp

    @if($opportunities->isNotEmpty())

        {{-- Hero --}}
        <div
            class="
                card
                bg-base-100
                border
                border-base-300
                shadow-sm
                mb-8
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
                            بهترین فرصت فعلی
                        </div>

                        <h2
                            class="
                                text-4xl
                                font-black
                            "
                        >
                            {{ $topOpportunity->topic->name }}
                        </h2>

                        <p
                            class="
                                mt-2
                                text-base-content/70
                            "
                        >
                            مهم‌ترین فرصت شناسایی شده توسط موتور تحلیل TIP
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
                                    $topOpportunity
                                        ->details
                                        ->opportunityScore
                                ) . ' امتیاز'
                            "
                            icon="o-chart-bar"
                            class="badge-primary"
                        />

                        <x-badge
                            :value="
                                $opportunities->count()
                                . ' فرصت'
                            "
                            icon="o-light-bulb"
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
                $opportunities as $item
            )

                <x-panel.opportunity-card
                    :topic="$item->topic"
                    :details="$item->details"
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

                همه فرصت‌ها نمایش داده شدند

            </div>

        @endif

    @else

        <x-panel.empty-state
            title="فرصتی پیدا نشد"
            description="هنوز فرصت معناداری برای نمایش وجود ندارد."
            icon="o-light-bulb"
        />

    @endif

</div>
