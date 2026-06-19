@props(['type' => 'success', 'message' => ''])

@php
    $classes = match($type) {
        'success' => 'flash-success',
        'error' => 'flash-error',
        default => 'flash-success',
    };

    $icon = match($type) {
        'success' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        'error' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        default => '',
    };
@endphp

<div x-data="{ visible: true }"
     x-show="visible"
     x-transition:leave.duration.300ms
     {{ $attributes->merge(['class' => $classes . ' rounded-xl p-4 flex items-center gap-3']) }}>
    @if($icon)
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            {!! $icon !!}
        </svg>
    @endif
    <p class="text-sm font-medium flex-1">{{ $message ?? $slot }}</p>
    <button @click="visible = false" class="hover:opacity-70">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
</div>
