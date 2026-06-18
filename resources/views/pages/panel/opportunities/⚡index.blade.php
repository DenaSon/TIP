<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;

use Domains\Opportunity\Actions\GetTopOpportunitiesAction;

new #[Layout('layouts::panel', [
    'title' => 'فرصت‌ها',
])]
class extends Component
{
    #[Computed]
    public function opportunities()
    {
        return app(
            GetTopOpportunitiesAction::class
        )->execute();
    }
};

?>

<div>

    <x-panel.page-header
        title="فرصت‌ها"
        description="بهترین فرصت‌های شناسایی شده توسط موتور تحلیل TIP"
    />

    @php
        $topOpportunity = $this->opportunities->first();
    @endphp

    {{-- Hero Section --}}
    <div
        class="
            hero
            bg-base-100
            border
            border-base-300
            rounded-box
            mb-8
        "
    >

        <div
            class="
                hero-content
                w-full
                justify-between
                flex-col
                lg:flex-row
            "
        >

            <div>

                <div
                    class="
                        badge
                        badge-primary
                        mb-3
                    "
                >
                    بهترین فرصت فعلی
                </div>

                <h2
                    class="
                        text-3xl
                        font-bold
                    "
                >
                    {{ $topOpportunity?->topic->name }}
                </h2>

                <p
                    class="
                        mt-2
                        text-base-content/70
                    "
                >
                    فرصت شناسایی شده توسط موتور تحلیل TIP
                </p>

            </div>

            <div
                class="
                    flex
                    gap-6
                "
            >

                <div
                    class="
                        text-center
                    "
                >

                    <div
                        class="
                            text-4xl
                            font-black
                            text-primary
                        "
                    >
                        {{ round(
                            $topOpportunity?->details->opportunityScore ?? 0
                        ) }}
                    </div>

                    <div
                        class="
                            text-sm
                            text-base-content/60
                        "
                    >
                        امتیاز فرصت
                    </div>

                </div>

                <div
                    class="
                        text-center
                    "
                >

                    <div
                        class="
                            text-4xl
                            font-black
                        "
                    >
                        {{ $this->opportunities->count() }}
                    </div>

                    <div
                        class="
                            text-sm
                            text-base-content/60
                        "
                    >
                        فرصت فعال
                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- Opportunities Grid --}}
    <div
        class="
            grid
            gap-6
            md:grid-cols-2
            xl:grid-cols-3
        "
    >

        @foreach(
            $this->opportunities
            as $item
        )

            <x-panel.opportunity-card
                :topic="$item->topic"
                :details="$item->details"
            />

        @endforeach

    </div>

</div>
