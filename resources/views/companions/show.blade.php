@extends('layouts.guest')

@section('content')
<div class="bg-surface-container-low min-h-screen">
    <!-- Hero Section -->
    <div class="relative bg-primary text-white overflow-hidden pb-32">
        <div class="absolute inset-0 opacity-20">
            <img class="w-full h-full object-cover" src="{{ $aiCharacter->avatar_url ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuC2MButv0eycymNlfxEkXggP89tIXaX4J2t0BDpCwut0Lw3Jk2U5LxArNik7aYEI8lfNcmbyUOxcRay03jPCB2_oMq61k9ddVTMLxSjuNkZOWVVV_s-CiAgAPq_2zgmGL8KlACltZPnPHnEHtrU44EYv8hquyy9o-EInViCI51ZgEqtH7OksQP88yO2vds0GxVAA-6RoQoRSssSX5yD07v5akkGmLrpVklydkpMwpBnrMbmwACS9OhXhiQKNTdq7WHp1WZyiCobFgY' }}" alt="Backdrop">
            <div class="absolute inset-0 bg-black/50"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-primary to-transparent"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-6 md:px-12 relative z-10 pt-16 pb-12">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-semibold mb-6 shadow-sm border border-white/10 uppercase tracking-widest text-[#D4AF37]">
                    <span class="material-symbols-outlined text-[16px]">stars</span>
                    {{ $aiCharacter->occupation ?? 'Executive Professional' }}
                </div>
                <h1 class="text-5xl md:text-6xl font-extrabold tracking-tight mb-4 drop-shadow-md">
                    {{ $aiCharacter->name }}
                </h1>
                <p class="text-xl md:text-2xl opacity-90 font-medium leading-relaxed drop-shadow-sm">
                    "{{ $aiCharacter->tagline ?? 'Your dedicated partner for scaling business operations and driving exceptional results.' }}"
                </p>
            </div>
        </div>
    </div>

    <!-- Details Card -->
    <div class="max-w-7xl mx-auto px-6 md:px-12 relative z-20 -mt-24 pb-24">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Main Content -->
            <div class="lg:col-span-2 bg-white rounded-[2rem] p-8 md:p-12 shadow-xl border border-gray-100">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">psychology</span>
                    Professional Expertise
                </h2>
                <div class="prose prose-lg text-gray-600 leading-relaxed mb-10">
                    <p>
                        {{ $aiCharacter->bio ?? 'Equipped with deep industry insights and operational intelligence, this companion is designed to seamlessly integrate into your workflow. From high-level strategy and planning to day-to-day granular tasks, it exists to supercharge your productivity.' }}
                    </p>
                </div>
                
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">bolt</span>
                    Why Choose {{ explode(' ', $aiCharacter->name)[0] }}?
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                        <span class="material-symbols-outlined text-secondary-fixed-dim text-3xl mb-3">speed</span>
                        <h3 class="font-bold text-gray-900 mb-2">Rapid Execution</h3>
                        <p class="text-sm text-gray-500">Delivers comprehensive business tasks and generated reports instantly.</p>
                    </div>
                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                        <span class="material-symbols-outlined text-blue-400 text-3xl mb-3">auto_awesome</span>
                        <h3 class="font-bold text-gray-900 mb-2">High Precision</h3>
                        <p class="text-sm text-gray-500">Generates domain-specific metrics aligned precisely with your project goals.</p>
                    </div>
                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                        <span class="material-symbols-outlined text-amber-500 text-3xl mb-3">support_agent</span>
                        <h3 class="font-bold text-gray-900 mb-2">Contextual Memory</h3>
                        <p class="text-sm text-gray-500">Remembers your business details and recent tasks across sessions.</p>
                    </div>
                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                        <span class="material-symbols-outlined text-emerald-500 text-3xl mb-3">description</span>
                        <h3 class="font-bold text-gray-900 mb-2">Executive Reporting</h3>
                        <p class="text-sm text-gray-500">Automatically dispatches cleanly formatted PDF reports to your email.</p>
                    </div>
                </div>
            </div>

            <!-- Sticky CTA Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-[2rem] p-8 shadow-xl border border-gray-100 sticky top-24">
                    <div class="aspect-square w-full rounded-2xl overflow-hidden mb-8 shadow-md relative">
                        <img src="{{ $aiCharacter->avatar_url ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuC2MButv0eycymNlfxEkXggP89tIXaX4J2t0BDpCwut0Lw3Jk2U5LxArNik7aYEI8lfNcmbyUOxcRay03jPCB2_oMq61k9ddVTMLxSjuNkZOWVVV_s-CiAgAPq_2zgmGL8KlACltZPnPHnEHtrU44EYv8hquyy9o-EInViCI51ZgEqtH7OksQP88yO2vds0GxVAA-6RoQoRSssSX5yD07v5akkGmLrpVklydkpMwpBnrMbmwACS9OhXhiQKNTdq7WHp1WZyiCobFgY' }}" alt="{{ $aiCharacter->name }}" class="w-full h-full object-cover">
                        @if($aiCharacter->is_premium)
                        <div class="absolute top-4 right-4 bg-black/70 backdrop-blur border border-[#D4AF37]/50 rounded-xl px-3 py-1.5 flex items-center gap-2 shadow-lg">
                            <span class="text-lg">👑</span>
                            <span class="text-[#D4AF37] font-bold text-xs uppercase tracking-widest">Premium</span>
                        </div>
                        @endif
                    </div>
                    
                    <div class="mb-8">
                        <p class="text-sm text-gray-500 font-semibold mb-1 uppercase tracking-wide">Investment</p>
                        <div class="flex items-baseline gap-2">
                            <span class="text-4xl font-extrabold text-gray-900">${{ number_format($aiCharacter->monthly_price, 2) }}</span>
                            <span class="text-lg text-gray-500">/ month</span>
                        </div>
                        <p class="text-xs text-gray-400 mt-2">Billed monthly. Cancel anytime.</p>
                    </div>

                    <button @click="waitlistModalOpen = true" class="w-full flex items-center justify-center gap-2 bg-primary hover:bg-primary-container text-white text-lg font-bold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 active:scale-95">
                        <span class="material-symbols-outlined">lock_open</span>
                        Subscribe & Unlock
                    </button>
                    
                    <div class="mt-6 flex flex-col gap-3">
                        <div class="flex items-center gap-3 text-sm text-gray-600">
                            <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-600"><span class="material-symbols-outlined text-sm">verified</span></div>
                            Immediate Access
                        </div>
                        <div class="flex items-center gap-3 text-sm text-gray-600">
                            <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-600"><span class="material-symbols-outlined text-sm">lock</span></div>
                            Secure Stripe Checkout
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
