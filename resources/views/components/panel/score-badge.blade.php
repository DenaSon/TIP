@props([
    'value',
])

@php

    $class = match (true) {

        $value >= 70 => 'badge-success',

        $value >= 40 => 'badge-warning',

        default => 'badge-error',
    };

@endphp

<div
    @class([
        'badge',
        $class,
    ])
>
    {{ round($value) }}
</div>
