<aside
    class="
        bg-base-100
        min-h-full
        w-72
        border-l
        border-base-300
        flex
        flex-col
    "
>

    {{-- Brand --}}
    <div
        class="
            px-6
            py-6
            border-b
            border-base-300
        "
    >

        <div class="flex items-center gap-3">

            <div
                class="
                    size-11
                    rounded-2xl
                    bg-primary
                    text-primary-content
                    flex
                    items-center
                    justify-center
                    shadow-sm
                "
            >
                <x-icon
                    name="o-bolt"
                    class="w-6 h-6"
                />
            </div>

            <div>

                <div
                    class="
                        text-lg
                        font-bold
                    "
                >
                    TIP
                </div>

                <div
                    class="
                        text-xs
                        text-base-content/60
                    "
                >
                    Trend Intelligence Platform
                </div>

            </div>

        </div>

    </div>

    {{-- Navigation --}}
    <div class="flex-1 py-4">

        <ul class="menu w-full gap-1">

            <li class="menu-title">

                <span>
                    اکتشاف
                </span>

            </li>

            <li>

                <a
                    wire:navigate
                    wire:current="menu-active"
                    href="{{ route('panel.opportunities.index') }}"
                >

                    <x-icon
                        name="o-light-bulb"
                        class="w-5 h-5"
                    />

                    <span>
                        فرصت‌ها
                    </span>

                </a>

            </li>

            <li>

                <a
                    wire:navigate
                    wire:current="menu-active"
                    href="{{ route('panel.topics.index') }}"
                >

                    <x-icon
                        name="o-circle-stack"
                        class="w-5 h-5"
                    />

                    <span>
                        موضوعات
                    </span>

                </a>

            </li>

            <li>

                <a
                    wire:navigate
                    wire:current="menu-active"
                    href="{{ route('panel.trends.index') }}"
                >

                    <x-icon
                        name="o-fire"
                        class="w-5 h-5"
                    />

                    <span>
                        روندها
                    </span>

                </a>

            </li>

        </ul>

    </div>

    {{-- Footer --}}
    <div
        class="
            border-t
            border-base-300
            p-4
        "
    >

        <div class="space-y-4">

            <div>

                <div
                    class="
                        text-xs
                        text-base-content/60
                        mb-1
                    "
                >
                    وضعیت سیستم
                </div>

                <div
                    class="
                        flex
                        items-center
                        gap-2
                    "
                >

                    <span
                        class="
                            size-2.5
                            rounded-full
                            bg-success
                            animate-pulse
                        "
                    ></span>

                    <span
                        class="
                            text-sm
                            font-medium
                        "
                    >
                        فعال
                    </span>

                </div>

            </div>

            <div>

                <div
                    class="
                        text-xs
                        text-base-content/60
                        mb-1
                    "
                >
                    آخرین بروزرسانی
                </div>

                <div
                    class="
                        text-sm
                        font-medium
                    "
                >
                    چند لحظه پیش
                </div>

            </div>

            <div
                class="
                    pt-2
                    text-xs
                    text-base-content/50
                "
            >
                Version 0.4
            </div>

        </div>

    </div>

</aside>
