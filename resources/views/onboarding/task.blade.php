@extends('layouts.onboarding', ['step' => 8])

@section('content')
<div class="max-w-3xl mx-auto space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="text-center space-y-4">
        <h1 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tight">Let's get to work</h1>
        <p class="text-lg text-slate-500 max-w-2xl mx-auto">What's keeping you awake at night? Tell your companion about your most urgent task or biggest current challenge.</p>
    </div>

    <div class="bg-white rounded-[3rem] p-8 md:p-12 shadow-xl shadow-slate-200/50 border border-slate-100">
        <form action="{{ route('onboarding.complete') }}" method="POST" class="space-y-8">
            @csrf
            
            <div class="space-y-2">
                <label for="current_problems" class="block text-sm font-bold text-slate-700 ml-1">Current Challenges (Optional)</label>
                <textarea name="current_problems" id="current_problems" rows="3" placeholder="e.g. Sales plateaued, hiring is slow, scaling technical infrastructure..."
                    class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all duration-300"></textarea>
            </div>

            <div class="space-y-2">
                <label for="urgent_tasks" class="block text-sm font-bold text-slate-700 ml-1">Most Urgent Task (Optional)</label>
                <textarea name="urgent_tasks" id="urgent_tasks" rows="3" placeholder="e.g. Need a GTM strategy for our new feature launch by Friday..."
                    class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all duration-300"></textarea>
            </div>

            <div class="pt-6 flex flex-col items-center gap-4">
                <button type="submit" class="w-full py-5 bg-primary hover:bg-primary-container text-white font-black text-2xl rounded-2xl shadow-xl shadow-primary/20 transition-all active:scale-[0.98] flex items-center justify-center gap-3">
                    Finish & Start Work
                    <span class="material-symbols-outlined font-bold text-3xl">task_alt</span>
                </button>
                <button type="submit" class="text-slate-400 hover:text-slate-600 transition-colors font-medium text-sm">
                    Skip this for now and go to Dashboard
                </button>
            </div>
        </form>
    </div>

    <!-- Security Note -->
    <div class="flex items-center justify-center gap-2 text-slate-400">
        <span class="material-symbols-outlined text-[18px]">lock</span>
        <span class="text-xs">Your data is encrypted and used only for your projects.</span>
    </div>
</div>
@endsection
