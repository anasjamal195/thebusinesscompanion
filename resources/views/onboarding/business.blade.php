@php
    $title = 'Business Info';
    $pageTitle = 'Business Info';
    $activeNav = 'dashboard';
@endphp

@extends('layouts.app')

@section('content')
    <div class="max-w-3xl">
        <x-card>
            <div>
                <h2 class="text-base font-semibold text-gray-900">Tell us about your business</h2>
                <p class="mt-1 text-sm text-gray-500">Dummy fields only. Focus is UI structure and style.</p>
            </div>

            <form method="POST" action="{{ route('onboarding.business.save') }}" class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                @csrf
                <div class="sm:col-span-2">
                    <label class="text-sm font-medium text-gray-900">Business name</label>
                    <input name="business_name" value="{{ old('business_name') }}" class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Acme Inc." required />
                    @error('business_name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-900">Industry</label>
                    <input name="industry" value="{{ old('industry') }}" class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="SaaS" />
                    @error('industry')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-900">Business type</label>
                    <select name="business_type" class="mt-2 w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500" required>
                        @php $bt = old('business_type', 'startup'); @endphp
                        @foreach (['freelancer','startup','agency','ecommerce','local_business','enterprise'] as $type)
                            <option value="{{ $type }}" {{ $bt === $type ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ', $type)) }}</option>
                        @endforeach
                    </select>
                    @error('business_type')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="text-sm font-medium text-gray-900">Target audience</label>
                    <textarea name="target_audience" rows="3" class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Who do you serve?">{{ old('target_audience') }}</textarea>
                    @error('target_audience')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="text-sm font-medium text-gray-900">Goals</label>
                    <textarea name="goals" rows="3" class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="What do you want to achieve?">{{ old('goals') }}</textarea>
                    @error('goals')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="text-sm font-medium text-gray-900">Challenges</label>
                    <textarea name="challenges" rows="3" class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="What’s hard right now?">{{ old('challenges') }}</textarea>
                    @error('challenges')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="text-sm font-medium text-gray-900">What are you trying to achieve?</label>
                    <div class="mt-2 grid grid-cols-1 gap-3 sm:grid-cols-3">
                        @php $xl = old('experience_level', 'beginner'); @endphp
                        @foreach (['beginner','intermediate','expert'] as $level)
                            <label class="cursor-pointer">
                                <input type="radio" name="experience_level" value="{{ $level }}" class="peer sr-only" {{ $xl === $level ? 'checked' : '' }} />
                                <div class="rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm shadow-sm transition hover:border-blue-500 peer-checked:border-blue-600 peer-checked:bg-blue-50">
                                    <div class="font-semibold text-gray-900">{{ ucfirst($level) }}</div>
                                    <div class="mt-0.5 text-xs text-gray-500">Experience level</div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('experience_level')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2 mt-2 flex items-center justify-between gap-3">
                    <x-button variant="outline" href="{{ route('onboarding.role') }}">Back</x-button>
                    <x-button type="submit">Continue</x-button>
                </div>
            </form>
        </x-card>
    </div>
@endsection
