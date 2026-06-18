@props([
    'trend',
])

@php

    $status =
        match (true) {

            $trend->growth_rate >= 80
                => 'انفجاری',

            $trend->growth_rate >= 50
                => 'داغ',

            $trend->growth_rate >= 20
                => 'در حال رشد',

            default
                => 'پایدار',
        };

    $statusColor =
        match (true) {

            $trend->growth_rate >= 80
                => 'badge-error',

            $trend->growth_rate >= 50
                => 'badge-warning',

            $trend->growth_rate >= 20
                => 'badge-success',

            default
                => 'badge-info',
        };

    $summary =
        match (true) {

            $trend->growth_rate >= 80
                => 'افزایش شدید توجه و رشد سریع محتوا',

            $trend->growth_rate >= 50
                => 'روند در حال جذب توجه گسترده است',

            $trend->growth_rate >= 20
                => 'رشد مثبت در حال مشاهده است',

            default
                => 'روند در وضعیت نسبتاً پایدار قرار دارد',
        };

@endphp

<div
    class="
        card
        bg-base-100
        border
        border-base-300
        shadow-sm
        hover:shadow-xl
        hover:-translate-y-1
        transition-all
        duration-300
    "
>

    <div
        class="
            card-body
            bg-gradient-to-br
            from-primary/5
            via-transparent
            to-success/5
        "
    >

        {{-- Header --}}
        <div
            class="
                flex
                items-start
                justify-between
                gap-4
            "
        >

            <div>

                <div
                    class="
                        badge
                        {{ $statusColor }}
                        badge-outline
                        mb-3
                    "
                >
                    {{ $status }}
                </div>

                <h3
                    class="
                        text-2xl
                        font-black
                    "
                >
                    {{ $trend->topic->name }}
                </h3>

            </div>

            {{-- Trend Score --}}
            <div
                class="
                    text-center
                    shrink-0
                "
            >

                <div
                    class="
                        radial-progress
                        text-primary
                    "
                    style="
                        --value:{{ min(round($trend->score),100) }};
                        --size:5rem;
                    "
                >

                    {{ round($trend->score) }}

                </div>

                <div
                    class="
                        text-xs
                        mt-2
                        text-base-content/60
                    "
                >
                    امتیاز روند
                </div>

            </div>

        </div>

        {{-- Narrative --}}
        <div
            class="
                alert
                alert-soft
                mt-5
            "
        >

            <x-icon
                name="o-fire"
                class="w-5 h-5"
            />

            <span
                class="
                    text-sm
                "
            >
                {{ $summary }}
            </span>

        </div>

        {{-- Metrics --}}
        <div
            class="
                grid
                grid-cols-3
                gap-3
                mt-5
            "
        >

            {{-- Growth --}}
            <div
                class="
                    rounded-box
                    bg-base-200
                    p-3
                    text-center
                "
            >

                <x-icon
                    name="o-arrow-trending-up"
                    class="
                        w-5
                        h-5
                        mx-auto
                        mb-2
                        text-success
                    "
                />

                <div
                    class="
                        text-2xl
                        font-bold
                    "
                >
                    {{ round(
                        $trend->growth_rate
                    ) }}
                </div>

                <div
                    class="
                        text-xs
                        text-base-content/60
                    "
                >
                    رشد
                </div>

            </div>

            {{-- Velocity --}}
            <div
                class="
                    rounded-box
                    bg-base-200
                    p-3
                    text-center
                "
            >

                <x-icon
                    name="o-bolt"
                    class="
                        w-5
                        h-5
                        mx-auto
                        mb-2
                        text-warning
                    "
                />

                <div
                    class="
                        text-2xl
                        font-bold
                    "
                >
                    {{ round(
                        $trend->velocity
                    ) }}
                </div>

                <div
                    class="
                        text-xs
                        text-base-content/60
                    "
                >
                    سرعت
                </div>

            </div>

            {{-- Authority --}}
            <div
                class="
                    rounded-box
                    bg-base-200
                    p-3
                    text-center
                "
            >

                <x-icon
                    name="o-shield-check"
                    class="
                        w-5
                        h-5
                        mx-auto
                        mb-2
                        text-info
                    "
                />

                <div
                    class="
                        text-2xl
                        font-bold
                    "
                >
                    {{ round(
                        $trend->authority_score
                    ) }}
                </div>

                <div
                    class="
                        text-xs
                        text-base-content/60
                    "
                >
                    اعتبار
                </div>

            </div>

        </div>

    </div>

</div>
