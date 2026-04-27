@props([
    'status' => 'active', // active | pending | completed
])

@php
    $classes = match ($status) {
        'completed' => 'bg-green-50 text-green-700 ring-1 ring-green-200',
        'pending' => 'bg-gray-100 text-gray-700 ring-1 ring-gray-200',
        default => 'bg-blue-50 text-blue-700 ring-1 ring-blue-200',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {$classes}"]) }}>
    {{ $slot }}
</span>

