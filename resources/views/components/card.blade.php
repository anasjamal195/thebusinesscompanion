@props([
    'padding' => 'p-5',
    'hover' => false,
])

<div {{ $attributes->merge(['class' => "rounded-xl border border-gray-200 bg-white shadow-sm {$padding}" . ($hover ? ' hover:border-gray-300 hover:shadow-md transition-all duration-200' : '')]) }}>
    {{ $slot }}
</div>
