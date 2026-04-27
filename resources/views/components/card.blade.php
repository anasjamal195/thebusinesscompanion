@props([
    'p' => 'p-8',
    'glass' => false,
])

<div {{ $attributes->merge(['class' => ($glass ? 'glass-panel ' : 'bg-white ') . "rounded-[2.5rem] border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] transition-all duration-300 hover:shadow-[0_12px_40px_rgba(0,0,0,0.04)] {$p}"]) }}>
    {{ $slot }}
</div>


