<?php

use Domains\Topic\Actions\GetTopicDrillDownAction;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;

use Domains\Topic\Models\Topic;
use Domains\Opportunity\Actions\GetOpportunityDetailsAction;

new #[Layout('layouts::panel', [
    'title' => 'جزئیات فرصت',
])]
class extends Component {
    public Topic $topic;

    #[Computed]
    public function drillDown()
    {
        return app(
            GetTopicDrillDownAction::class
        )->execute(
            $this->topic
        );
    }

    #[Computed]
    public function data()
    {
        return app(
            GetOpportunityDetailsAction::class
        )->execute(
            $this->topic
        );
    }
};

?>

<div wire:cloak>

    @php

        $opportunity =
            $this->data['opportunity'];

        $profile =
            $this->data['profile'];

    @endphp

    <x-panel.page-header
        :title="$profile->topic"
        description="تحلیل فرصت و هوش موضوع"
    />

    {{-- Hero --}}
    {{-- Hero --}}
    <div
        class="
        card
        bg-base-100
        border
        border-base-300
        shadow-sm
        mb-8
        overflow-hidden
    "
    >

        <div
            class="
            card-body
            p-8
            lg:p-10
        "
        >

            <div
                class="
                flex
                flex-col
                lg:flex-row
                lg:items-center
                lg:justify-between
                gap-8
            "
            >

                {{-- Content --}}
                <div class="flex-1">

                    <div
                        class="
        flex
        flex-wrap
        items-center
        gap-2
        mb-4
    "
                    >

                        <div
                            class="
            badge
            badge-outline
            badge-primary
        "
                        >
                            فرصت شناسایی شده
                        </div>

                        <div
                            class="
            badge
            badge-outline
        "
                        >

                            {{ count($profile->signals) }}

                            سیگنال فعال

                        </div>

                    </div>

                    <h1
                        class="
                        text-4xl
                        lg:text-6xl
                        font-black
                        mb-5
                    "
                    >
                        {{ $profile->topic }}
                    </h1>

                    <p
                        class="
                        text-base-content/70
                        leading-9
                        max-w-4xl
                        text-lg
                    "
                    >
                        {{ $profile->narrative->summary }}
                    </p>

                </div>

                {{-- Score --}}
                <div
                    class="
                    shrink-0
                "
                >

                    <div
                        class="
                        card
                        bg-primary
                        text-primary-content
                        shadow-xl
                        min-w-56
                    "
                    >

                        <div
                            class="
                            card-body
                            items-center
                            text-center
                            py-8
                        "
                        >

                            <div
                                class="
                                text-primary-content/70
                                text-sm
                            "
                            >
                                امتیاز
                            </div>

                            <div
                                class="
                                text-6xl
                                font-black
                            "
                            >
                                {{ round(
                                    $opportunity->opportunityScore
                                ) }}
                            </div>

                            <div
                                class="
                                mt-3
                                flex
                                items-center
                                gap-2
                                text-sm
                            "
                            >

                                <x-icon
                                    name="o-shield-check"
                                    class="w-4 h-4"
                                />

                                <span>

                                اعتماد

                                {{ round(
                                    $opportunity
                                        ->confidence
                                        ->score
                                ) }}%

                            </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Signals --}}
    @if(count($profile->signals))

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
                items-center
                justify-between
                mb-2
            "
                >

                    <h2 class="card-title">

                        <x-icon
                            name="o-sparkles"
                            class="w-6 h-6 text-primary"
                        />

                        سیگنال‌های استراتژیک

                    </h2>

                    <div class="badge badge-outline badge-success text-xs">

                        {{ count($profile->signals) }}
                        سیگنال فعال

                    </div>

                </div>

                <div
                    class="
                grid
                gap-4
                md:grid-cols-2
            "
                >

                    @foreach(
                        $profile->signals
                        as $signal
                    )

                        <div
                            class="
                        card
                        bg-gradient-to-br
                        from-primary/5
                        to-primary/10
                        border
                        border-primary/20
                        hover:shadow-lg
                        hover:-translate-y-1
                        transition-all
                        duration-300
                    "
                        >

                            <div class="card-body">

                                <div
                                    class="
                                flex
                                items-start
                                gap-3
                            "
                                >

                                    <div
                                        class="
                                    size-12
                                    rounded-xl
                                    bg-primary/10
                                    flex
                                    items-center
                                    justify-center
                                    shrink-0
                                "
                                    >

                                        <x-icon
                                            :name="$signal->signal->icon()"
                                            class="
                                        w-6
                                        h-6
                                        text-primary
                                    "
                                        />

                                    </div>

                                    <div class="flex-1">

                                        <h3
                                            class="
                                        font-bold
                                        text-lg
                                        mb-1
                                    "
                                        >
                                            {{ $signal->title }}
                                        </h3>

                                        <p
                                            class="
                                        text-sm
                                        text-base-content/70
                                        leading-7
                                    "
                                        >
                                            {{ $signal->description }}
                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

        </div>

    @endif



    {{-- Opportunity Reasons --}}
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

            <h2
                class="
                    card-title
                "
            >
                دلایل شناسایی فرصت
            </h2>

            <div
                class="
                    flex
                    flex-wrap
                    gap-2
                "
            >

                @foreach(
                    $opportunity->reasons
                    as $reason
                )

                    <ul
                        class="
        timeline
        timeline-vertical
    "
                    >

                        @foreach(
                            $opportunity->reasons
                            as $reason
                        )

                            <li>

                                <div
                                    class="
                    timeline-middle
                "
                                >

                                    <x-icon
                                        name="o-check-circle"
                                        class="
                        w-5
                        h-5
                        text-success
                    "
                                    />

                                </div>

                                <div
                                    class="
                    timeline-end
                    mb-6
                "
                                >

                                    <div
                                        class="
                        font-semibold
                    "
                                    >
                                        {{ $reason->title }}
                                    </div>

                                    <div
                                        class="
                        text-sm
                        text-base-content/60
                    "
                                    >
                                        {{ $reason->description }}
                                    </div>

                                </div>

                                <hr/>

                            </li>

                        @endforeach

                    </ul>

                @endforeach

            </div>

        </div>

    </div>

    {{-- Evidence Layer --}}
    <div
        class="
        card
        bg-base-100
        border
        border-base-300
        shadow-sm
        mt-6
    "
    >

        <div class="card-body">

            <div
                class="
                flex
                items-center
                justify-between
                mb-4
            "
            >

                <h2 class="card-title">

                    <x-icon
                        name="o-squares-plus"
                        class="w-5 h-5 text-primary"
                    />


                    زیرموضوع‌های مرتبط
                </h2>

                <div
                    class="
                    badge
                    badge-outline
                    badge-primary
                    text-xs
                "
                >

                    {{ count(
                        $this->drillDown->clusters
                    ) }}

                    زیرموضوع‌های مرتبط

                </div>

            </div>

            <div class="space-y-3">

                @foreach(
                    $this->drillDown->clusters
                    as $cluster
                )

                    <div
                        class="
                        collapse
                        collapse-plus
                        bg-base-100
                        border
                        border-base-300
                    "
                    >

                        <input
                            type="radio"
                            name="cluster-accordion"
                        />

                        <div
                            class="
                            collapse-title
                            py-4
                        "
                        >

                            <div
                                class="
                                flex
                                items-center
                                justify-between
                                gap-4
                            "
                            >

                                <div>

                                    <div
                                        class="
                                        font-semibold
                                        text-sm
                                    "
                                    >
                                        {{ $cluster->name }}
                                    </div>

                                    <div
                                        class="
        text-xs
        text-base-content/60
        mt-1
    "
                                    >

                                        {{ $cluster->content_count }}
                                        محتوا •

                                        آخرین فعالیت
                                        {{ $cluster->last_content_at?->diffForHumans() }}

                                    </div>

                                </div>

                                <div
                                    class="
                                    badge
                                    badge-outline text-xs
                                "
                                >

                                    {{ $cluster->content_count }}

                                    محتوا

                                </div>

                            </div>

                        </div>

                        <div
                            class="
                            collapse-content
                        "
                        >

                            <div
                                class="
                                space-y-2
                            "
                            >

                                @foreach(
                                    $cluster->contents->take(5)
                                    as $content
                                )

                                    <div
                                        class="
                                        p-3
                                        rounded-xl
                                        bg-base-200
                                        hover:bg-base-300
                                        transition
                                    "
                                    >

                                        <div
                                            class="
                                            text-sm
                                            font-medium
                                            leading-7
                                        "
                                        >
                                            {{ $content->title }}
                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    </div>

    {{-- Intelligence Overview --}}
    <div
        class="
        stats
        stats-vertical
        2xl:stats-horizontal
        bg-base-100
        border
        border-base-300
        shadow-sm
        w-full
        mb-6
    "
    >

        <div class="stat">

            <div class="stat-figure text-primary">

                <x-icon
                    name="o-bolt"
                    class="w-8 h-8"
                />

            </div>

            <div class="stat-title">
                مومنتوم
            </div>

            <div class="stat-value text-primary">
                {{ round($profile->momentum) }}
            </div>

            <div
                class="
                stat-desc
                {{ $profile->momentum >= 50
                    ? 'text-success'
                    : 'text-warning'
                }}
            "
            >
                {{ $profile->momentum >= 50
                    ? 'مومنتوم قوی'
                    : 'مومنتوم متوسط'
                }}
            </div>

        </div>

        <div class="stat">

            <div class="stat-figure text-success">

                <x-icon
                    name="o-shield-check"
                    class="w-8 h-8"
                />

            </div>

            <div class="stat-title">
                اعتبار
            </div>

            <div class="stat-value text-success">
                {{ round($profile->authorityScore) }}
            </div>

            <div class="stat-desc">

                {{ $profile->authorityScore >= 85
                    ? 'منابع معتبر'
                    : 'اعتبار متوسط'
                }}

            </div>

        </div>

        <div class="stat">

            <div class="stat-figure text-info">

                <x-icon
                    name="o-heart"
                    class="w-8 h-8"
                />

            </div>

            <div class="stat-title">
                سلامت
            </div>

            <div class="stat-value text-info">
                {{ $profile->health->health->label() }}
            </div>

            <div class="stat-desc">
                وضعیت فعلی موضوع
            </div>

        </div>

        <div class="stat">

            <div class="stat-figure text-secondary">

                <x-icon
                    name="o-arrow-trending-up"
                    class="w-8 h-8"
                />

            </div>

            <div class="stat-title">
                چرخه عمر
            </div>

            <div class="stat-value text-secondary">
                {{ $profile->lifecycle->lifecycle->label() }}
            </div>

            <div class="stat-desc">
                مرحله رشد موضوع
            </div>

        </div>

        <div class="stat">

            <div class="stat-figure text-accent">

                <x-icon
                    name="o-document-text"
                    class="w-8 h-8"
                />

            </div>

            <div class="stat-title">
                محتوا
            </div>

            <div class="stat-value">
                {{ $profile->contentCount }}
            </div>

            <div class="stat-desc">
                محتوای تحلیل شده
            </div>

        </div>

        <div class="stat">

            <div class="stat-figure text-warning">

                <x-icon
                    name="o-squares-2x2"
                    class="w-8 h-8"
                />

            </div>

            <div class="stat-title">
                زیرموضوع‌های مرتبط
            </div>

            <div class="stat-value text-warning">
                {{ $profile->clusterCount }}
            </div>

            <div class="stat-desc">
                خوشه فعال
            </div>

        </div>

    </div>

    {{-- Narrative --}}

</div>
