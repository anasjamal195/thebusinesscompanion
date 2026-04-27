@php
    $title = 'Dashboard';
    $pageTitle = 'Dashboard';
    $activeNav = 'dashboard';
@endphp

@extends('layouts.app')

@section('content')
<div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <!-- Welcome Header -->
    <div class="relative overflow-hidden bg-white rounded-[3rem] p-8 md:p-12 shadow-xl shadow-gray-200/50 border border-gray-100 group">
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-primary/5 rounded-full blur-3xl group-hover:bg-primary/10 transition-colors duration-700"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-8">
            <div class="space-y-4">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-primary/10 text-primary rounded-full text-xs font-black uppercase tracking-wider">
                    <span class="material-symbols-outlined text-[16px]">verified</span>
                    <span>Workspace Active</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 tracking-tight">
                    Welcome back, <span class="text-primary">{{ explode(' ', auth()->user()->name)[0] }}</span>.
                </h2>
                <p class="text-lg text-gray-500 max-w-xl font-medium">
                    Your companion has processed <span class="text-gray-900 font-bold">12 tasks</span> this week. Everything is looking good.
                </p>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('projects.index') }}" class="px-8 py-4 bg-primary hover:bg-primary-container text-white font-bold rounded-2xl shadow-xl shadow-primary/20 transition-all active:scale-95 flex items-center gap-3">
                    <span class="material-symbols-outlined">add</span>
                    New Project
                </a>
            </div>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column: Active Projects -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-[2.5rem] p-8 shadow-lg shadow-gray-200/30 border border-gray-50">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-2xl font-black text-gray-900 tracking-tight">Active Projects</h3>
                        <p class="text-sm text-gray-500 font-medium">Quick overview of your current focuses.</p>
                    </div>
                    <a href="{{ route('projects.index') }}" class="text-sm font-bold text-primary hover:underline">View All</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach (($projects ?? collect()) as $p)
                        <a href="{{ route('projects.show', $p) }}" class="group relative overflow-hidden bg-gray-50/50 hover:bg-white rounded-3xl p-6 border border-transparent hover:border-primary/20 hover:shadow-xl hover:shadow-primary/5 transition-all duration-300">
                            <div class="flex items-start justify-between gap-4 relative z-10">
                                <div class="space-y-1">
                                    <h4 class="font-black text-gray-900 group-hover:text-primary transition-colors">{{ $p['name'] }}</h4>
                                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">{{ $p['domain'] ?? 'General' }}</p>
                                </div>
                                <span class="material-symbols-outlined text-primary opacity-0 group-hover:opacity-100 transition-all group-hover:translate-x-1">arrow_forward</span>
                            </div>
                            <div class="mt-6 flex items-center gap-4">
                                <div class="flex-grow h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-primary rounded-full transition-all duration-1000" style="width: 65%"></div>
                                </div>
                                <span class="text-[10px] font-black text-gray-400">65%</span>
                            </div>
                        </a>
                    @endforeach

                    @if (($projects ?? collect())->isEmpty())
                        <div class="md:col-span-2 p-12 text-center bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200">
                            <span class="material-symbols-outlined text-4xl text-gray-300 mb-4">folder_off</span>
                            <p class="text-gray-500 font-medium mb-4">No active projects yet.</p>
                            <a href="{{ route('projects.index') }}" class="text-primary font-bold hover:underline">Create your first project</a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-[2.5rem] p-8 shadow-lg shadow-gray-200/30 border border-gray-50">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-2xl font-black text-gray-900 tracking-tight">Recent Tasks</h3>
                        <p class="text-sm text-gray-500 font-medium">Updates from your digital employee.</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center justify-center p-12 bg-gray-50/50 rounded-3xl border border-gray-100">
                        <div class="text-center">
                            <span class="material-symbols-outlined text-4xl text-gray-200 mb-2">pending_actions</span>
                            <p class="text-gray-400 text-sm font-medium">Recent tasks will appear as your companion works.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: AI Insights & Status -->
        <div class="space-y-8">
            <div class="bg-gray-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden shadow-xl shadow-gray-900/20">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-primary/20 rounded-full blur-3xl"></div>
                <h3 class="text-xl font-black mb-6 flex items-center gap-2 relative z-10">
                    <span class="material-symbols-outlined text-primary">auto_awesome</span>
                    Daily Insights
                </h3>
                
                <div class="space-y-4 relative z-10">
                    <div class="bg-white/5 rounded-2xl p-5 border border-white/10 hover:bg-white/10 transition-colors">
                        <p class="text-xs font-bold text-primary uppercase tracking-widest mb-1 leading-none">Recommendation</p>
                        <p class="text-sm font-medium text-gray-300">Check the market analysis for Acme. I've found 3 new competitors.</p>
                    </div>
                    <div class="bg-white/5 rounded-2xl p-5 border border-white/10 hover:bg-white/10 transition-colors">
                        <p class="text-xs font-bold text-green-400 uppercase tracking-widest mb-1 leading-none">Status</p>
                        <p class="text-sm font-medium text-gray-300">GTM Strategy for Project Northstar is 80% complete.</p>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-white/10">
                    <button class="w-full py-4 bg-white text-gray-900 font-bold rounded-2xl hover:bg-gray-100 transition-all active:scale-95 flex items-center justify-center gap-2 text-sm shadow-xl shadow-black/20">
                        <span class="material-symbols-outlined text-[18px]">chat</span>
                        Ask your Companion
                    </button>
                </div>
            </div>

            <!-- Subscription Status -->
            <div class="bg-white rounded-[2.5rem] p-8 shadow-lg shadow-gray-200/30 border border-gray-50 overflow-hidden relative group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-150 duration-700"></div>
                <h3 class="text-lg font-black text-gray-900 mb-6">Plan Status</h3>
                
                <div class="flex items-center gap-4 mb-6">
                    <div class="h-12 w-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center">
                        <span class="material-symbols-outlined text-[24px]">workspace_premium</span>
                    </div>
                    <div>
                        <p class="text-sm font-black text-gray-900">Business Pro</p>
                        <p class="text-xs text-gray-500 font-medium">Renews in 12 days</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex justify-between text-xs font-bold">
                        <span class="text-gray-500 uppercase tracking-widest">Task Credits</span>
                        <span class="text-gray-900 underline">84 / 100</span>
                    </div>
                    <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-primary rounded-full scale-x-75 origin-left"></div>
                    </div>
                </div>

                <a href="{{ route('onboarding.business') }}" class="mt-8 block w-full text-center py-3 rounded-xl border border-gray-200 text-xs font-bold text-gray-600 hover:bg-gray-50 hover:border-gray-300 transition-all active:scale-95">Manage Subscription</a>
            </div>
        </div>
    </div>
</div>
@endsection
