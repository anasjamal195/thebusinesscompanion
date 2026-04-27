@extends('layouts.onboarding', ['step' => 1])

@section('content')
<div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="text-center space-y-4">
        <h1 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tight">Select your professional role</h1>
        <p class="text-lg text-slate-500 max-w-2xl mx-auto">Tell us what you do, and we'll tailor your Business Companion's expertise to your specific industry needs.</p>
    </div>

    <form action="{{ route('onboarding.role.save') }}" method="POST">
        @csrf
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4" x-data="{ selected: '' }">
            @php
            $roles = [
                ['name' => 'Founder', 'icon' => 'rocket_launch'],
                ['name' => 'Engineer', 'icon' => 'terminal'],
                ['name' => 'Marketer', 'icon' => 'campaign'],
                ['name' => 'Researcher', 'icon' => 'biotech'],
                ['name' => 'Sales', 'icon' => 'payments'],
                ['name' => 'HR', 'icon' => 'groups'],
                ['name' => 'Consultant', 'icon' => 'query_stats'],
                ['name' => 'Analyst', 'icon' => 'monitoring'],
                ['name' => 'Creator', 'icon' => 'article'],
                ['name' => 'Musician', 'icon' => 'music_note'],
                ['name' => 'Trader', 'icon' => 'trending_up'],
                ['name' => 'Teacher', 'icon' => 'school'],
                ['name' => 'Student', 'icon' => 'edit_note'],
                ['name' => 'Doctor', 'icon' => 'medical_services'],
                ['name' => 'Transportation', 'icon' => 'local_shipping'],
                ['name' => 'Manufacturing', 'icon' => 'factory'],
            ];
            @endphp

            @foreach($roles as $role)
            <label class="relative cursor-pointer group">
                <input type="radio" name="role" value="{{ $role['name'] }}" class="peer sr-only" @click="selected = '{{ $role['name'] }}'" required>
                <div class="p-6 bg-white border-2 border-slate-100 rounded-3xl shadow-sm transition-all duration-300 group-hover:border-primary/30 group-hover:shadow-md peer-checked:border-primary peer-checked:bg-primary/5 peer-checked:shadow-primary/10 flex flex-col items-center text-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-600 transition-colors group-hover:bg-primary/10 group-hover:text-primary peer-checked:bg-primary peer-checked:text-white">
                        <span class="material-symbols-outlined text-2xl">{{ $role['icon'] }}</span>
                    </div>
                    <span class="font-bold text-sm text-slate-900">{{ $role['name'] }}</span>
                </div>
                <div class="absolute -top-2 -right-2 w-6 h-6 bg-primary text-white rounded-full flex items-center justify-center scale-0 transition-transform duration-300 peer-checked:scale-100">
                    <span class="material-symbols-outlined text-[16px] font-bold">check</span>
                </div>
            </label>
            @endforeach
        </div>

        <div class="mt-12 flex justify-center">
            <button type="submit" class="group px-12 py-4 bg-primary hover:bg-primary-container text-white font-bold rounded-2xl shadow-xl shadow-primary/20 transition-all active:scale-95 flex items-center gap-2">
                Continue to Companion
                <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
            </button>
        </div>
    </form>
</div>
@endsection
