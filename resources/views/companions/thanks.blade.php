@extends('layouts.guest')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4">
    <div class="max-w-xl w-full text-center space-y-8">
        <div class="inline-flex items-center justify-center w-24 h-24 bg-primary/10 rounded-full text-primary mb-4 animate-pulse">
            <span class="material-symbols-outlined text-5xl">rocket_launch</span>
        </div>
        
        <div class="space-y-4">
            <h1 class="text-4xl md:text-6xl font-black text-gray-900 tracking-tight">Coming Soon</h1>
            <p class="text-xl text-gray-500 font-medium">Thank you for your interest! We are currently in private beta and finalizing your companion's workspace.</p>
        </div>

        <div class="bg-gray-50 border border-gray-100 rounded-3xl p-8 shadow-sm">
            <p class="text-gray-600 leading-relaxed font-medium">
                We have added you to our priority waitlist. Your spot is reserved and we will keep you updated via email as soon as we open the next batch of dedicated machines.
            </p>
        </div>

        <div class="pt-8">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-primary font-bold hover:underline">
                <span class="material-symbols-outlined">arrow_back</span>
                Back to Home
            </a>
        </div>
    </div>
</div>
@endsection
