@props(['score' => 0, 'size' => 'sm'])

@php
    $color = match(true) {
        $score >= 80 => 'border-green-500 text-green-700 dark:text-green-400',
        $score >= 50 => 'border-amber-500 text-amber-700 dark:text-amber-400',
        default => 'border-red-500 text-red-700 dark:text-red-400',
    };

    $dimensions = $size === 'lg'
        ? 'w-20 h-20 text-lg'
        : 'w-[52px] h-[52px] text-sm';
@endphp

<div class="score-ring {{ $color }} {{ $dimensions }}">
    {{ intval($score) }}
</div>
