@props([
    'topic',
])

<div
    class="
        card
        bg-base-100
        border
        border-base-300
        shadow-sm
        hover:shadow-lg
        hover:-translate-y-1
        transition-all
        duration-300
    "
>

    <div class="card-body">

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

                <div class="flex items-center gap-2 mb-2">

                    <div
                        class="
                    badge
                    badge-outline
                    badge-primary
                "
                    >
                        {{ $topic
                            ->lifecycle
                            ->lifecycle
                            ->label() }}
                    </div>

                    <div
                        class="
                    badge
                    badge-outline
                "
                    >
                        {{ count($topic->signals) }}
                        سیگنال
                    </div>

                </div>

                <h3
                    class="
                text-2xl
                font-black
            "
                >
                    {{ $topic->topic }}
                </h3>

            </div>

            <div
                class="
            text-center
            shrink-0
        "
            >

                <div
                    class="
                text-5xl
                font-black
                text-primary
                leading-none
            "
                >
                    {{ round(
                        $topic->opportunityScore
                    ) }}
                </div>

                <div
                    class="
                text-xs
                text-base-content/60
                mt-1
            "
                >
                    امتیاز فرصت
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
                name="o-light-bulb"
                class="w-5 h-5"
            />

            <span
                class="
            text-sm
            leading-7
        "
            >
        {{ $topic->narrative->summary }}
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
                text-primary
                mb-1
            "
                />

                <div
                    class="
                text-xl
                font-bold
                text-primary
            "
                >
                    {{ round(
                        $topic->momentum
                    ) }}
                </div>

                <div
                    class="
                text-xs
                text-base-content/60
            "
                >
                    مومنتوم
                </div>

            </div>

            <div
                class="
            rounded-box
            bg-base-200
            p-3
            text-center
        "
            >

                <x-icon
                    name="o-document-text"
                    class="
                w-5
                h-5
                mx-auto
                text-info
                mb-1
            "
                />

                <div
                    class="
                text-xl
                font-bold
                text-info
            "
                >
                    {{ $topic->contentCount }}
                </div>

                <div
                    class="
                text-xs
                text-base-content/60
            "
                >
                    محتوا
                </div>

            </div>

            <div
                class="
            rounded-box
            bg-base-200
            p-3
            text-center
        "
            >

                <x-icon
                    name="o-squares-2x2"
                    class="
                w-5
                h-5
                mx-auto
                text-warning
                mb-1
            "
                />

                <div
                    class="
                text-xl
                font-bold
                text-warning
            "
                >
                    {{ $topic->clusterCount }}
                </div>

                <div
                    class="
                text-xs
                text-base-content/60
            "
                >
                    زیرموضوع
                </div>

            </div>

        </div>

        {{-- Footer --}}
        <div
            class="
        flex
        items-center
        gap-2
        {{ $topic->health->health->color() }}
    "
        >

            <x-icon
                :name="$topic->health->health->icon()"
                class="w-5 h-5"
            />

            <span
                class="
            text-sm
            font-medium
        "
            >
        {{ $topic->health->health->label() }}
    </span>

        </div>

    </div>

</div>
