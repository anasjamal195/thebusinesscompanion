@extends('layouts.onboarding', ['step' => 7])

@section('content')
<div class="max-w-3xl mx-auto space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="text-center space-y-4">
        <h1 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tight">Industry Context</h1>
        <p class="text-lg text-slate-500 max-w-2xl mx-auto">Let's refine your companion's industry-specific knowledge to provide more accurate assistance.</p>
    </div>

    <div class="bg-white rounded-[3rem] p-8 md:p-12 shadow-xl shadow-slate-200/50 border border-slate-100 space-y-8">
        <div class="p-6 bg-primary/5 border border-primary/10 rounded-2xl flex items-start gap-4">
            <span class="material-symbols-outlined text-primary mt-0.5">info</span>
            <div class="space-y-1">
                <p class="text-sm font-black text-slate-900 uppercase tracking-widest">Proofreading Step</p>
                <p class="text-slate-600 text-sm font-medium">Please review the details captured during your call. This is also the perfect time to add your business URL and any other specifics your companion might have missed.</p>
            </div>
        </div>

        <form action="{{ route('onboarding.details.save') }}" method="POST" class="space-y-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label for="business_name" class="block text-sm font-bold text-slate-700 ml-1">Business Name</label>
                    <input type="text" name="business_name" id="business_name" required placeholder="e.g. Acme Corp"
                        value="{{ auth()->user()->profile->business_name ?? '' }}"
                        class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all duration-300">
                </div>

                <div class="space-y-2">
                    <label for="business_url" class="block text-sm font-bold text-slate-700 ml-1">Business URL (Website)</label>
                    <input type="url" name="business_url" id="business_url" placeholder="https://example.com"
                        value="{{ auth()->user()->profile->business_url ?? '' }}"
                        class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all duration-300">
                </div>
            </div>
                <div class="space-y-2">
                    <label for="business_type" class="block text-sm font-bold text-slate-700 ml-1">Business Type</label>
                    <select name="business_type" id="business_type" required
                        class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all duration-300">
                        <option value="">Select one...</option>
                        <option value="SaaS" {{ (auth()->user()->profile->business_type ?? '') == 'SaaS' ? 'selected' : '' }}>SaaS / Software</option>
                        <option value="Agency" {{ (auth()->user()->profile->business_type ?? '') == 'Agency' ? 'selected' : '' }}>Service Agency</option>
                        <option value="E-commerce" {{ (auth()->user()->profile->business_type ?? '') == 'E-commerce' ? 'selected' : '' }}>E-commerce / Retail</option>
                        <option value="Local Business" {{ (auth()->user()->profile->business_type ?? '') == 'Local Business' ? 'selected' : '' }}>Local Service Business</option>
                        <option value="Freelancer" {{ (auth()->user()->profile->business_type ?? '') == 'Freelancer' ? 'selected' : '' }}>Solo Freelancer / Consultant</option>
                        <option value="Enterprise" {{ (auth()->user()->profile->business_type ?? '') == 'Enterprise' ? 'selected' : '' }}>Mid-size to Enterprise</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label for="industry" class="block text-sm font-bold text-slate-700 ml-1">Industry Vertical</label>
                    <input type="text" name="industry" id="industry" required placeholder="e.g. FinTech, Healthcare, Logistics"
                        value="{{ auth()->user()->profile->industry ?? '' }}"
                        class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all duration-300">
                </div>
            </div>

            <div class="space-y-2">
                <label for="target_audience" class="block text-sm font-bold text-slate-700 ml-1">Who is your target audience?</label>
                <textarea name="target_audience" id="target_audience" rows="3" placeholder="Describe your ideal customers, their pain points, and why they choose you..."
                    class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all duration-300">{{ auth()->user()->profile->target_audience ?? '' }}</textarea>
            </div>

            <div class="space-y-4">
                <label class="block text-sm font-bold text-slate-700 ml-1">Your experience in this field</label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <label class="cursor-pointer group">
                        <input type="radio" name="experience_level" value="beginner" class="peer sr-only" required {{ (auth()->user()->profile->experience_level ?? '') == 'beginner' ? 'checked' : '' }}>
                        <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl text-center transition-all peer-checked:border-primary peer-checked:bg-primary/5">
                            <p class="font-bold text-slate-900 group-hover:text-primary transition-colors">Beginner</p>
                            <p class="text-[10px] text-slate-400 uppercase tracking-tighter">0-2 Years</p>
                        </div>
                    </label>
                    <label class="cursor-pointer group">
                        <input type="radio" name="experience_level" value="intermediate" class="peer sr-only" {{ (auth()->user()->profile->experience_level ?? 'intermediate') == 'intermediate' ? 'checked' : '' }}>
                        <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl text-center transition-all peer-checked:border-primary peer-checked:bg-primary/5">
                            <p class="font-bold text-slate-900 group-hover:text-primary transition-colors">Intermediate</p>
                            <p class="text-[10px] text-slate-400 uppercase tracking-tighter">2-7 Years</p>
                        </div>
                    </label>
                    <label class="cursor-pointer group">
                        <input type="radio" name="experience_level" value="expert" class="peer sr-only" {{ (auth()->user()->profile->experience_level ?? '') == 'expert' ? 'checked' : '' }}>
                        <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl text-center transition-all peer-checked:border-primary peer-checked:bg-primary/5">
                            <p class="font-bold text-slate-900 group-hover:text-primary transition-colors">Expert / Executive</p>
                            <p class="text-[10px] text-slate-400 uppercase tracking-tighter">7+ Years</p>
                        </div>
                    </label>
                </div>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit" class="group px-12 py-4 bg-primary hover:bg-primary-container text-white font-bold rounded-2xl shadow-xl shadow-primary/20 transition-all active:scale-95 flex items-center gap-2">
                    Final Step
                    <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">auto_awesome</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
