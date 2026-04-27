@extends('layouts.onboarding', ['step' => 5])

@section('content')
<div class="max-w-4xl mx-auto space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="text-center space-y-4">
        <h1 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tight">Configure calling setup</h1>
        <p class="text-lg text-slate-500 max-w-2xl mx-auto">Your Business Companion can hop on a call with you anytime. Let's set the ground rules for your interactions.</p>
    </div>

    <div class="bg-white rounded-[3rem] p-8 md:p-12 shadow-xl shadow-slate-200/50 border border-slate-100">
        <form action="{{ route('onboarding.calling.save') }}" method="POST" class="space-y-10">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Left Side: Basic Config -->
                <div class="space-y-8">
                    <div class="space-y-2">
                        <label for="phone_number" class="block text-sm font-bold text-slate-700 ml-1">Your Phone Number</label>
                        <div class="relative">
                            <span class="absolute left-5 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400">call</span>
                            <input type="text" name="phone_number" id="phone_number" required placeholder="+1 (555) 000-0000"
                                class="w-full pl-14 pr-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all duration-300">
                        </div>
                    </div>

                    <div class="space-y-4">
                        <label class="block text-sm font-bold text-slate-700 ml-1">Call Limits</label>
                        <div class="grid grid-cols-1 gap-4">
                            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-primary">timer</span>
                                    <span class="text-sm font-medium text-slate-600">Max Duration (min)</span>
                                </div>
                                <input type="number" name="max_call_duration" value="15" min="1" max="60" required
                                    class="w-20 px-3 py-2 bg-white border border-slate-200 rounded-xl text-center font-bold focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-primary">call_log</span>
                                    <span class="text-sm font-medium text-slate-600">Daily Call Limit</span>
                                </div>
                                <input type="number" name="daily_calling_limit" value="5" min="1" max="20" required
                                    class="w-20 px-3 py-2 bg-white border border-slate-200 rounded-xl text-center font-bold focus:ring-2 focus:ring-primary/20 focus:border-primary">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side: Availability -->
                <div class="space-y-4">
                    <label class="block text-sm font-bold text-slate-700 ml-1">Availability Hours</label>
                    <div class="bg-slate-50 rounded-[2rem] p-6 border border-slate-200 space-y-4">
                        @php
                        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                        @endphp
                        @foreach($days as $day)
                        <div class="flex items-center justify-between group">
                            <span class="text-sm font-semibold text-slate-600">{{ $day }}</span>
                            <div class="flex items-center gap-2">
                                <input type="time" name="availability_hours[{{ $day }}][start]" value="09:00"
                                    class="px-2 py-1 bg-white border border-slate-200 rounded-lg text-xs font-medium focus:ring-1 focus:ring-primary/30">
                                <span class="text-slate-300 text-xs">-</span>
                                <input type="time" name="availability_hours[{{ $day }}][end]" value="17:00"
                                    class="px-2 py-1 bg-white border border-slate-200 rounded-lg text-xs font-medium focus:ring-1 focus:ring-primary/30">
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="pt-6 flex justify-center">
                <button type="submit" class="group px-16 py-5 bg-primary hover:bg-primary-container text-white font-black text-xl rounded-2xl shadow-xl shadow-primary/20 transition-all active:scale-95 flex items-center gap-3">
                    Continue to Onboarding Mode
                    <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">rocket</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
