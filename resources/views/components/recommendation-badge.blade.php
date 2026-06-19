@props(['recommendation' => ''])

@php
    $value = $recommendation instanceof \App\Enums\Recommendation ? $recommendation->value : $recommendation;

    $class = match($value) {
        'convoquer' => 'badge-green',
        'attente' => 'badge-amber',
        'rejeter' => 'badge-red',
        default => 'badge-gray',
    };

    $label = match($value) {
        'convoquer' => 'À convoquer',
        'attente' => 'En attente',
        'rejeter' => 'À rejeter',
        default => $value,
    };
@endphp

<span {{ $attributes->merge(['class' => $class]) }}>
    {{ $label }}
</span>
