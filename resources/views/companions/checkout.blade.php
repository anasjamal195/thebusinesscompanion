@extends('layouts.guest')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-16 sm:px-6 lg:px-8">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        
        <!-- Header -->
        <div class="bg-gray-50 border-b border-gray-100 p-6 md:p-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Secure Checkout</h1>
                <p class="text-sm text-gray-500 mt-1">Unlock The Business Companion</p>
            </div>
            <div class="text-right">
                <span class="block text-sm text-gray-500">Total Billed</span>
                <span class="block text-2xl font-bold text-[#D4AF37]">
                    ${{ number_format($aiCharacter->monthly_price, 2) }}
                    <span class="text-sm text-gray-400 font-normal">/mo</span>
                </span>
            </div>
        </div>

        <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-2 gap-12">
            
            <!-- Summary Column -->
            <div class="order-2 md:order-1 flex flex-col justify-center">
                <div class="flex items-center gap-4 mb-6">
                    <img src="{{ $aiCharacter->avatar_url ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuC2MButv0eycymNlfxEkXggP89tIXaX4J2t0BDpCwut0Lw3Jk2U5LxArNik7aYEI8lfNcmbyUOxcRay03jPCB2_oMq61k9ddVTMLxSjuNkZOWVVV_s-CiAgAPq_2zgmGL8KlACltZPnPHnEHtrU44EYv8hquyy9o-EInViCI51ZgEqtH7OksQP88yO2vds0GxVAA-6RoQoRSssSX5yD07v5akkGmLrpVklydkpMwpBnrMbmwACS9OhXhiQKNTdq7WHp1WZyiCobFgY' }}" 
                         alt="{{ $aiCharacter->name }}" 
                         class="w-16 h-16 rounded-full object-cover shadow-md border border-gray-200">
                    <div>
                        <h3 class="font-bold text-gray-900">{{ $aiCharacter->name }}</h3>
                        <p class="text-xs text-gray-500">{{ $aiCharacter->occupation ?? 'The Business Companion' }}</p>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div class="flex items-center gap-3 text-sm text-gray-600">
                        <span class="text-green-500 font-bold">✓</span>
                        Full access to intelligence and chat
                    </div>
                    <div class="flex items-center gap-3 text-sm text-gray-600">
                        <span class="text-green-500 font-bold">✓</span>
                        Comprehensive Task PDF Reporting
                    </div>
                    <div class="flex items-center gap-3 text-sm text-gray-600">
                        <span class="text-green-500 font-bold">✓</span>
                        Secure payment processing by Stripe
                    </div>
                </div>
            </div>

            <!-- Form Column -->
            <div class="order-1 md:order-2 border-l border-gray-100 md:pl-8">
                <form action="{{ route('companions.processCheckout', $aiCharacter->id) }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Create your account</h2>

                    @if ($errors->any())
                        <div class="rounded-md bg-red-50 p-4 mb-4">
                            <div class="flex">
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">There were errors with your submission</h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <ul class="list-disc pl-5 space-y-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" name="name" id="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-2 border" value="{{ old('name') }}">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input type="email" name="email" id="email" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-2 border" value="{{ old('email') }}">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Secure Password</label>
                        <input type="password" name="password" id="password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-2 border">
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            Continue to Payment
                        </button>
                    </div>
                    <p class="text-xs text-center text-gray-500 mt-4">
                        By continuing, you agree to our Terms of Service and Privacy Policy. You will be redirected to Stripe to securely complete your subscription.
                    </p>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
