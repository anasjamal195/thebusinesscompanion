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
            
            <div class="space-y-4">
                <div class="space-y-2">
                    <label for="project_name" class="block text-sm font-bold text-slate-700 ml-1">Project Name</label>
                    <input type="text" name="project_name" id="project_name" required placeholder="Name your first project (e.g. Acme Corp Launch)"
                        class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all duration-300 font-medium">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label for="project_url" class="block text-sm font-bold text-slate-700 ml-1">Project URL (Optional)</label>
                        <input type="url" name="project_url" id="project_url" placeholder="https://example.com"
                            class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all duration-300 font-medium">
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="project_description" class="block text-sm font-bold text-slate-700 ml-1">Project Objective / Description</label>
                    <textarea name="project_description" id="project_description" rows="2" placeholder="What are we trying to achieve with this project?"
                        class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all duration-300 font-medium"></textarea>
                </div>

                <div class="space-y-2">
                    <label for="success_metric" class="block text-sm font-bold text-slate-700 ml-1">Success Metric (Optional)</label>
                    <input type="text" name="success_metric" id="success_metric" placeholder="What would make this project a success? (e.g. 10% increase in leads)"
                        class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all duration-300 font-medium">
                </div>
            </div>

            <div class="space-y-4 pt-4 border-t border-slate-100">
                <div class="space-y-2">
                    <label for="current_problems" class="block text-sm font-bold text-slate-700 ml-1">Current Challenges & Pain Points</label>
                    <textarea name="current_problems" id="current_problems" rows="2" placeholder="e.g. Sales plateaued, hiring is slow, scaling technical infrastructure..."
                        class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all duration-300 font-medium"></textarea>
                </div>

                <div class="space-y-2">
                    <label for="urgent_tasks" class="block text-sm font-bold text-slate-700 ml-1">Most Urgent Task</label>
                    <textarea name="urgent_tasks" id="urgent_tasks" rows="2" placeholder="e.g. Need a GTM strategy for our new feature launch by Friday..."
                        class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all duration-300 font-medium"></textarea>
                </div>
            </div>

            <div class="pt-6 flex flex-col items-center gap-4">
                <button type="submit" class="w-full py-5 bg-primary hover:bg-primary-container text-white font-black text-2xl rounded-2xl shadow-xl shadow-primary/20 transition-all active:scale-[0.98] flex items-center justify-center gap-3">
                    Finish & Start Work
                    <span class="material-symbols-outlined font-bold text-3xl">task_alt</span>
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
