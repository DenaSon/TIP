@props([
    'score',
])

@php

    [$label, $class] = match (true) {

        $score >= 80
            => ['اعتماد بالا', 'badge-success'],

        $score >= 50
            => ['اعتماد متوسط', 'badge-warning'],

        default
            => ['اعتماد پایین', 'badge-error'],
    };

@endphp

<div
    @class([
        'badge',
        $class,
    ])
>
    {{ $label }}
</div>
