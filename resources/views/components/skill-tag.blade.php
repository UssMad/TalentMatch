@props(['skill' => '', 'max' => null])

@php
    $isTruncated = $max && mb_strlen($skill) > $max;
    $display = $isTruncated ? mb_substr($skill, 0, $max) . '…' : $skill;
@endphp

<span {{ $attributes->merge(['class' => 'badge-gray']) }}
      @if($isTruncated)
          x-data x-tooltip.raw="{{ $skill }}"
      @endif
>
    {{ $display }}
</span>
