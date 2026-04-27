@props([
    'variant' => 'primary', // primary | outline | ghost
    'href' => null,
    'type' => 'button',
])

@php
    $base = 'inline-flex items-center justify-center gap-2 rounded-2xl px-5 py-3 text-sm font-bold transition-all duration-200 active:scale-95 focus:outline-none focus:ring-4 focus:ring-primary/10';
    $styles = match ($variant) {
        'outline' => 'border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 hover:border-gray-300',
        'ghost' => 'text-gray-500 hover:bg-gray-50 hover:text-gray-900',
        default => 'bg-primary text-white shadow-lg shadow-primary/20 hover:bg-primary-container',
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


