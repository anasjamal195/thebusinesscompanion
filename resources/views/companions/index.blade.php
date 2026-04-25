@extends('layouts.guest')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-slate-900 border-none bg-transparent">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">
            Select The Business Companion
        </h1>
        <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
            Browse our curated list of professional AI agents ready to elevate your business.
        </p>
    </div>

    <!-- Companions Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($companions as $companion)
            <a href="{{ route('companions.show', $companion->id) }}" class="group block cursor-pointer">
                <div class="relative w-full aspect-[2/3] rounded-2xl overflow-hidden shadow-lg transition-transform duration-300 group-hover:scale-[1.02] bg-gray-900 border border-gray-100">
                    
                    <!-- Avatar Image placeholder (using a nice generic one if avatar_url is missing) -->
                    <img src="{{ $companion->avatar_url ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuC2MButv0eycymNlfxEkXggP89tIXaX4J2t0BDpCwut0Lw3Jk2U5LxArNik7aYEI8lfNcmbyUOxcRay03jPCB2_oMq61k9ddVTMLxSjuNkZOWVVV_s-CiAgAPq_2zgmGL8KlACltZPnPHnEHtrU44EYv8hquyy9o-EInViCI51ZgEqtH7OksQP88yO2vds0GxVAA-6RoQoRSssSX5yD07v5akkGmLrpVklydkpMwpBnrMbmwACS9OhXhiQKNTdq7WHp1WZyiCobFgY' }}" 
                         alt="{{ $companion->name }}" 
                         class="absolute inset-0 w-full h-full object-cover">
                    
                    <!-- Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent"></div>

                    <!-- Premium Crown (Top Right) -->
                    @if($companion->is_premium)
                        <div class="absolute top-0 right-0 bg-black/80 rounded-bl-xl border-l border-b border-[#D4AF37] px-3 py-2 shadow-lg">
                            <span class="text-lg">👑</span>
                        </div>
                    @endif

                    <!-- Details Overlay -->
                    <div class="absolute bottom-6 left-4 right-4 flex flex-col items-center text-center">
                        <div class="flex items-center gap-2">
                            <h3 class="text-2xl font-bold text-white drop-shadow-md">
                                {{ $companion->name }}
                            </h3>
                            @if($companion->is_premium)
                                <span class="text-lg text-[#D4AF37] drop-shadow-lg">👑</span>
                            @endif
                        </div>
                        <p class="mt-2 text-sm text-gray-300 font-medium tracking-wide bg-black/50 px-2 py-1 rounded backdrop-blur-sm">
                            {{ $companion->occupation ?? 'Professional Assistant' }}
                        </p>
                        
                        <!-- Price Badge -->
                        <div class="mt-4 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-black/60 border border-[#D4AF37]/50 backdrop-blur-md">
                            <span class="text-[#D4AF37] font-bold text-sm">
                                ${{ number_format($companion->monthly_price, 2) }} / mo
                            </span>
                        </div>
                    </div>

                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection
