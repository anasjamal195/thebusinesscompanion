@props([
    'variant' => 'primary',
    'href' => null,
    'type' => 'button',
    'size' => 'md',
])

@php
    $base = 'inline-flex items-center justify-center gap-2 rounded-lg font-semibold transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:ring-offset-1 focus:ring-offset-white';
    $sizes = [
        'sm' => 'px-3 py-1.5 text-xs',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-5 py-2.5 text-sm',
    ];
    $styles = match ($variant) {
        'outline' => 'border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 hover:border-gray-300 shadow-sm',
        'ghost' => 'text-gray-600 hover:bg-gray-100 hover:text-gray-800',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 shadow-sm',
        default => 'bg-primary text-white hover:bg-primary-container shadow-sm',
    };
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $base . ' ' . $sizes[$size] . ' ' . $styles]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $base . ' ' . $sizes[$size] . ' ' . $styles]) }}>
        {{ $slot }}
    </button>
@endif
