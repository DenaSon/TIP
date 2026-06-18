@props([
    'topic',
    'details',
])

@php

    $score = round(
        $details->opportunityScore
    );

    $confidence = round(
        $details->confidence->score
    );

    [$confidenceLabel, $confidenceClass] = match (true) {

        $confidence >= 80
            => ['اعتماد بالا', 'badge-success'],

        $confidence >= 50
            => ['اعتماد متوسط', 'badge-warning'],

        default
            => ['اعتماد پایین', 'badge-error'],
    };

@endphp

<div
    class="
        card
        bg-base-100
        border
        border-base-300
        shadow-sm
        hover:shadow-lg
        transition-all
        duration-300
    "
>

    <div class="card-body">

        <div
            class="
                flex
                items-start
                justify-between
                gap-4
            "
        >

            <div>

                <h3
                    class="
                        text-xl
                        font-bold
                    "
                >
                    {{ $topic->name }}
                </h3>

                <p
                    class="
                        text-sm
                        text-base-content/60
                        mt-1
                    "
                >
                    فرصت شناسایی شده توسط موتور تحلیل TIP
                </p>

            </div>

            <div
                class="
                    text-center
                "
            >

                <div
                    class="
                        text-3xl
                        font-black
                        text-primary
                    "
                >
                    {{ $score }}
                </div>

                <div
                    class="
                        text-xs
                        text-base-content/60
                    "
                >
                    Opportunity
                </div>

            </div>

        </div>

        <div class="divider my-1"></div>

        <div
            class="
                flex
                items-center
                justify-between
            "
        >

            <div
                class="
                    flex
                    items-center
                    gap-2
                "
            >

                <x-icon
                    name="o-shield-check"
                    class="w-4 h-4"
                />

                <span class="text-sm">

                    اعتماد داده

                </span>

            </div>

            <div
                class="
                    badge
                    {{ $confidenceClass }}
                "
            >

                {{ $confidenceLabel }}

            </div>

        </div>

        <div class="mt-4">

            <div
                class="
                    text-sm
                    font-medium
                    mb-2
                "
            >
                دلایل شناسایی
            </div>

            <div
                class="
                    flex
                    flex-wrap
                    gap-2
                "
            >

                @foreach(
                    array_slice(
                        $details->reasons,
                        0,
                        3
                    )
                    as $reason
                )

                    <div
                        class="
                            badge
                            badge-outline
                        "
                    >

                        {{ $reason->title }}

                    </div>

                @endforeach

            </div>

        </div>

        <div
            class="
                card-actions
                justify-end
                mt-6
            "
        >

            <button
                class="
                    btn
                    btn-primary
                    btn-sm
                "
            >


                <a
                    wire:navigate
                    href="{{ route(
        'panel.opportunities.show',
        $topic
    ) }}"
                    class="
        btn
        btn-primary
        btn-sm
    "
                >

                    <x-icon
                        name="o-arrow-left"
                        class="w-4 h-4"
                    />

                    مشاهده جزئیات

                </a>

            </button>

        </div>

    </div>

</div>
