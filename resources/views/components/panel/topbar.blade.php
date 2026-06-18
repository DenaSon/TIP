@props([
    'title' => null,
])

<header
    class="
        sticky
        top-0
        z-40
        border-b
        border-base-300
        bg-base-100/90
        backdrop-blur
    "
>

    <div
        class="
            navbar
            min-h-16
            px-4
            lg:px-6
        "
    >

        {{-- Right Side --}}
        <div class="navbar-start">

            <label
                for="panel-drawer"
                class="
                    btn
                    btn-ghost
                    btn-square
                    lg:hidden
                "
            >

                <x-icon
                    name="o-bars-3"
                    class="w-6 h-6"
                />

            </label>

            <div class="mr-2">

                @if($title)

                    <h1
                        class="
                            text-lg
                            font-bold
                        "
                    >
                        {{ $title }}
                    </h1>

                @endif

            </div>

        </div>

        {{-- Left Side --}}
        <div
            class="
                navbar-end
                gap-2
            "
        >

            <label
                class="
                    swap
                    swap-rotate
                    btn
                    btn-ghost
                    btn-circle
                "
            >

                <input
                    type="checkbox"
                    class="theme-controller"
                    value="night"
                />

                <x-icon
                    name="o-sun"
                    class="
                        swap-off
                        w-5
                        h-5
                    "
                />

                <x-icon
                    name="o-moon"
                    class="
                        swap-on
                        w-5
                        h-5
                    "
                />

            </label>

        </div>

    </div>

</header>
