@props([
    'p' => 'p-5',
])

<div {{ $attributes->merge(['class' => "rounded-xl border border-gray-200 bg-white shadow-sm {$p}"]) }}>
    {{ $slot }}
</div>

