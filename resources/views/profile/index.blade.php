@php
    $title = 'Profile';
    $pageTitle = 'My Profile';
    $activeNav = 'profile';
@endphp

@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="flex items-center justify-between">
        <h2 class="text-3xl font-black text-gray-900 tracking-tight">My Profile</h2>
        @if(session('success'))
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 text-green-600 rounded-xl text-sm font-bold border border-green-100">
                <span class="material-symbols-outlined text-[18px]">check_circle</span>
                {{ session('success') }}
            </div>
        @endif
        @if(request('refill') === 'success')
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 text-green-600 rounded-xl text-sm font-bold border border-green-100">
                <span class="material-symbols-outlined text-[18px]">check_circle</span>
                Credits refilled successfully!
            </div>
        @endif
        @if(request('refill') === 'cancelled')
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-50 text-yellow-600 rounded-xl text-sm font-bold border border-yellow-100">
                <span class="material-symbols-outlined text-[18px]">info</span>
                Refill was cancelled.
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left: User Info -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Profile Card -->
            <div class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-xl shadow-gray-200/50 border border-gray-100 space-y-6">
                <div class="flex items-center gap-6">
                    <div class="h-20 w-20 rounded-[2rem] bg-primary/10 text-primary flex items-center justify-center font-black text-3xl">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="text-2xl font-black text-gray-900">{{ $user->name }}</h3>
                        <p class="text-gray-500 font-medium">{{ $user->email }}</p>
                        <p class="text-xs font-bold text-gray-400 mt-1">Member since {{ $user->created_at->format('M Y') }}</p>
                    </div>
                </div>

                @if($profile)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-gray-100">
                    @if($profile->business_name)
                    <div>
                        <p class="text-xs font-black text-gray-400 uppercase tracking-widest">Business</p>
                        <p class="font-bold text-gray-900 mt-1">{{ $profile->business_name }}</p>
                    </div>
                    @endif
                    @if($profile->industry)
                    <div>
                        <p class="text-xs font-black text-gray-400 uppercase tracking-widest">Industry</p>
                        <p class="font-bold text-gray-900 mt-1">{{ $profile->industry }}</p>
                    </div>
                    @endif
                    @if($profile->phone_number)
                    <div>
                        <p class="text-xs font-black text-gray-400 uppercase tracking-widest">Phone</p>
                        <p class="font-bold text-gray-900 mt-1">{{ $profile->phone_number }}</p>
                    </div>
                    @endif
                    @if($profile->timezone ?? $user->timezone)
                    <div>
                        <p class="text-xs font-black text-gray-400 uppercase tracking-widest">Timezone</p>
                        <p class="font-bold text-gray-900 mt-1">{{ $user->timezone }}</p>
                    </div>
                    @endif
                </div>
                @endif

                <div class="pt-4 border-t border-gray-100">
                    <a href="{{ route('settings.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-50 text-gray-700 font-bold rounded-xl border border-gray-200 hover:bg-gray-100 transition-all text-sm">
                        <span class="material-symbols-outlined text-[18px]">edit</span>
                        Edit Profile
                    </a>
                </div>
            </div>

            <!-- Purchase History -->
            @if($purchases->isNotEmpty())
            <div class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-xl shadow-gray-200/50 border border-gray-100 space-y-6">
                <h3 class="text-xl font-black text-gray-900">Credit Purchase History</h3>
                <div class="space-y-3">
                    @foreach($purchases as $purchase)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl border border-gray-100">
                        <div class="flex items-center gap-3">
                            <span class="w-10 h-10 rounded-xl bg-green-100 text-green-600 flex items-center justify-center">
                                <span class="material-symbols-outlined text-[22px]">payments</span>
                            </span>
                            <div>
                                <p class="font-bold text-gray-900">+{{ number_format($purchase->credits_added, 2) }} Credits</p>
                                <p class="text-xs text-gray-500">${{ number_format($purchase->amount, 2) }} &middot; {{ $purchase->created_at->format('M d, Y g:i A') }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Right: Credits & Refill -->
        <div class="space-y-8">
            <!-- Credits Card -->
            <div class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-gray-200/50 border border-gray-100">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-[2rem] bg-primary/10 text-primary mb-4">
                        <span class="material-symbols-outlined text-[36px]">account_balance_wallet</span>
                    </div>
                    <h3 class="text-lg font-black text-gray-900 mb-1">Your Credits</h3>
                    <p class="text-4xl font-black text-primary mb-2">{{ number_format($user->credits, 2) }}</p>
                    <p class="text-sm text-gray-500 font-medium">1 credit = $1.00 USD</p>
                    <p class="text-xs text-gray-400 font-medium mt-2">Rate: ${{ number_format($monetization->per_minute_rate, 2) }}/min</p>
                </div>
            </div>

            <!-- Refill Card -->
            <div class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-gray-200/50 border border-gray-100">
                <h3 class="text-lg font-black text-gray-900 mb-4">Refill Credits</h3>
                <p class="text-sm text-gray-500 font-medium mb-6">Minimum refill is ${{ number_format($monetization->minimum_refill, 2) }}.</p>
                <form action="{{ route('stripe.checkout') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Amount (USD)</label>
                        <div class="relative">
                            <span class="absolute left-5 top-1/2 -translate-y-1/2 text-gray-400 font-bold text-lg">$</span>
                            <input type="number" name="amount" min="{{ $monetization->minimum_refill }}" step="1" value="{{ $monetization->minimum_refill }}" required
                                class="w-full pl-9 pr-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all font-bold text-lg">
                        </div>
                    </div>
                    <div class="flex gap-2 flex-wrap">
                        @foreach([5, 10, 25, 50] as $preset)
                            @if($preset >= $monetization->minimum_refill)
                            <button type="button" onclick="this.closest('form').querySelector('[name=amount]').value = '{{ $preset }}'" class="flex-1 px-3 py-2 bg-gray-50 text-gray-700 font-bold rounded-xl border border-gray-200 hover:bg-gray-100 transition-all text-xs">
                                ${{ $preset }}
                            </button>
                            @endif
                        @endforeach
                    </div>
                    <button type="submit" class="w-full py-4 bg-primary hover:bg-primary-container text-white font-bold rounded-2xl shadow-xl shadow-primary/20 transition-all active:scale-95 flex items-center justify-center gap-3">
                        <span class="material-symbols-outlined">bolt</span>
                        Add Credits
                    </button>
                </form>
                @if($errors->any())
                    <div class="mt-4 p-3 bg-red-50 text-red-600 rounded-xl text-sm font-medium border border-red-100">
                        {{ $errors->first() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
