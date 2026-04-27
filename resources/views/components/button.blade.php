@props([
    'variant' => 'primary', // primary | outline
    'href' => null,
    'type' => 'button',
])

@php
    $base = 'inline-flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-50';
    $styles = match ($variant) {
        'outline' => 'border border-gray-200 bg-white text-gray-900 hover:bg-gray-50',
        default => 'bg-blue-600 text-white hover:bg-blue-700',
    };
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $base . ' ' . $styles]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $base . ' ' . $styles]) }}>
        {{ $slot }}
    </button>
@endif

