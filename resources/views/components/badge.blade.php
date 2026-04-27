@props([
    'status' => 'active', // active | pending | completed | warning
])

@php
    $classes = match ($status) {
        'completed' => 'bg-green-50 text-green-700 ring-1 ring-green-100',
        'pending' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-100',
        'warning' => 'bg-red-50 text-red-700 ring-1 ring-red-100',
        default => 'bg-primary/10 text-primary ring-1 ring-primary/20',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-[11px] font-bold tracking-wide uppercase {$classes}"]) }}>
    <span class="w-1 h-1 rounded-full bg-current"></span>
    {{ $slot }}
</span>


