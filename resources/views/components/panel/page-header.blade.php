@props([
    'title',
    'description' => null,
])

<div class="mb-8">

    <h1 class="text-3xl font-bold">

        {{ $title }}

    </h1>

    @if($description)

        <p class="text-base-content/70 mt-2">

            {{ $description }}

        </p>

    @endif

</div>
