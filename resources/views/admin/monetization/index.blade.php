@extends('admin.layouts.app', ['title' => 'Monetization Settings', 'activeNav' => 'monetization', 'pageTitle' => 'Monetization Settings'])

@section('content')
<div class="max-w-2xl">
    <div class="rounded-2xl border border-gray-200 bg-white p-8">
        <form method="POST" action="{{ route('admin.monetization.update') }}">
            @csrf

            <div class="space-y-6">
                <div>
                    <label for="per_minute_rate" class="block text-sm font-bold text-gray-700 mb-2">Per-Minute Rate ($)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold">$</span>
                        <input type="number" step="0.01" min="0.01" id="per_minute_rate" name="per_minute_rate"
                            value="{{ old('per_minute_rate', $settings->per_minute_rate) }}"
                            class="w-full pl-8 pr-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition font-bold text-gray-900"
                            required>
                    </div>
                    @error('per_minute_rate')
                        <p class="mt-1 text-xs font-semibold text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="minimum_refill" class="block text-sm font-bold text-gray-700 mb-2">Minimum Refill ($)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold">$</span>
                        <input type="number" step="0.01" min="0.01" id="minimum_refill" name="minimum_refill"
                            value="{{ old('minimum_refill', $settings->minimum_refill) }}"
                            class="w-full pl-8 pr-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition font-bold text-gray-900"
                            required>
                    </div>
                    @error('minimum_refill')
                        <p class="mt-1 text-xs font-semibold text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-8 flex items-center gap-4">
                <button type="submit"
                    class="px-8 py-3 bg-primary text-white font-bold rounded-xl hover:bg-primary-container transition-all active:scale-95 shadow-lg shadow-primary/20">
                    Save Settings
                </button>
            </div>
        </form>

        <div class="mt-8 p-4 rounded-xl bg-blue-50 border border-blue-100">
            <div class="flex items-start gap-3">
                <span class="material-symbols-outlined text-blue-500 mt-0.5">info</span>
                <div>
                    <p class="text-sm font-bold text-blue-800">Current Configuration</p>
                    <p class="text-xs text-blue-600 mt-1">Users are charged <strong>${{ number_format($settings->per_minute_rate, 2) }}/min</strong> for calls. Minimum credit refill is <strong>${{ number_format($settings->minimum_refill, 2) }}</strong>.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
