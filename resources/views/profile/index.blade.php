@php
    $title = 'Profile';
    $pageTitle = 'My Profile';
    $activeNav = 'profile';
@endphp

@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-bold text-gray-900">Profile</h2>
        <div class="flex items-center gap-2">
            @if(session('success'))
                <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-green-50 text-green-700 rounded-lg text-sm font-medium border border-green-200">
                    <span class="material-symbols-outlined text-[16px]">check_circle</span>
                    {{ session('success') }}
                </div>
            @endif
            @if(request('refill') === 'success')
                <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-green-50 text-green-700 rounded-lg text-sm font-medium border border-green-200">
                    <span class="material-symbols-outlined text-[16px]">check_circle</span>
                    Credits refilled successfully!
                </div>
            @endif
            @if(request('refill') === 'cancelled')
                <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-yellow-50 text-yellow-700 rounded-lg text-sm font-medium border border-yellow-200">
                    <span class="material-symbols-outlined text-[16px]">info</span>
                    Refill cancelled.
                </div>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left: User Info --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Profile Card --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                <div class="flex items-center gap-4">
                    <div class="h-16 w-16 rounded-xl bg-primary/10 text-primary flex items-center justify-center font-bold text-2xl">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">{{ $user->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                        <p class="text-xs text-gray-400 mt-1">Member since {{ $user->created_at->format('M Y') }}</p>
                    </div>
                </div>

                @if($user->timezone)
                <div class="mt-4 pt-4 border-t border-gray-100 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[16px] text-gray-400">schedule</span>
                    <span class="text-sm text-gray-600">{{ $user->timezone }}</span>
                </div>
                @endif

                <div class="mt-4 pt-4 border-t border-gray-100 flex items-center gap-2 flex-wrap">
                    <a href="{{ route('settings.index') }}" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg border border-gray-200 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-all shadow-sm">
                        <span class="material-symbols-outlined text-[16px]">edit</span>
                        Edit Profile
                    </a>
                    <a href="{{ route('profiles.public', auth()->user()) }}" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg border border-gray-200 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-all shadow-sm">
                        <span class="material-symbols-outlined text-[18px]">public</span>
                        View Public Profile
                    </a>
                </div>
            </div>

            {{-- Purchase History --}}
            @if($purchases->isNotEmpty())
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Credit Purchase History</h3>
                <div class="space-y-2">
                    @foreach($purchases as $purchase)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-100">
                        <div class="flex items-center gap-3">
                            <span class="w-9 h-9 rounded-lg bg-green-50 text-green-600 flex items-center justify-center">
                                <span class="material-symbols-outlined text-[20px]">payments</span>
                            </span>
                            <div>
                                <p class="text-sm font-medium text-gray-900">+{{ number_format($purchase->credits_added, 2) }} Credits</p>
                                <p class="text-xs text-gray-500">${{ number_format($purchase->amount, 2) }} &middot; {{ $purchase->created_at->format('M d, Y g:i A') }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- Right: Credits & Refill --}}
        <div class="space-y-6">
            {{-- Credits Card --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-primary/10 text-primary mb-3">
                        <span class="material-symbols-outlined text-[28px]">account_balance_wallet</span>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-900 mb-1">Your Credits</h3>
                    <p class="text-3xl font-bold text-primary mb-1">{{ number_format($user->credits, 2) }}</p>
                    <p class="text-xs text-gray-500">1 credit = $1.00 USD</p>
                    <p class="text-[11px] text-gray-400 mt-2">Rate: ${{ number_format($monetization->per_minute_rate, 2) }}/min</p>
                </div>
            </div>

            {{-- Refill Card --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Refill Credits</h3>
                <p class="text-xs text-gray-500 mb-4">Minimum refill is ${{ number_format($monetization->minimum_refill, 2) }}.</p>
                <form action="{{ route('stripe.checkout') }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Amount (USD)</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 font-medium text-sm">$</span>
                            <input type="number" name="amount" min="{{ $monetization->minimum_refill }}" step="1" value="{{ $monetization->minimum_refill }}" required
                                class="w-full pl-7 pr-3 py-2 rounded-lg border border-gray-200 bg-gray-50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-medium">
                        </div>
                    </div>
                    <div class="flex gap-2">
                        @foreach([5, 10, 25, 50] as $preset)
                            @if($preset >= $monetization->minimum_refill)
                            <button type="button" onclick="this.closest('form').querySelector('[name=amount]').value = '{{ $preset }}'" class="flex-1 px-2 py-1.5 bg-gray-50 text-gray-600 font-medium rounded-lg border border-gray-200 hover:bg-gray-100 transition-all text-xs">
                                ${{ $preset }}
                            </button>
                            @endif
                        @endforeach
                    </div>
                    <button type="submit" class="w-full py-2.5 rounded-lg bg-primary text-white text-sm font-semibold hover:bg-primary-container transition-all shadow-sm flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">bolt</span>
                        Add Credits
                    </button>
                </form>
                @if($errors->any())
                    <div class="mt-3 p-2.5 bg-red-50 text-red-600 rounded-lg text-sm font-medium border border-red-200">
                        {{ $errors->first() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
