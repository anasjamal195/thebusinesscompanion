@props([
    'status' => 'active',
])

@php
    $classes = match ($status) {
        'completed' => 'bg-green-50 text-green-700 ring-1 ring-green-200',
        'pending' => 'bg-gray-100 text-gray-600 ring-1 ring-gray-200',
        'active' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-200',
        'error' => 'bg-red-50 text-red-700 ring-1 ring-red-200',
        'warning' => 'bg-yellow-50 text-yellow-700 ring-1 ring-yellow-200',
        default => 'bg-gray-100 text-gray-600 ring-1 ring-gray-200',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-md px-2 py-0.5 text-xs font-medium {$classes}"]) }}>
    {{ $slot }}
</span>
