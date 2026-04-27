@php
    $title = 'Dashboard';
    $pageTitle = 'Dashboard';
    $activeNav = 'dashboard';
@endphp

@extends('layouts.app')

@section('content')
    <!-- Welcome Header Card -->
    <div class="mb-10">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6 p-10 rounded-[3rem] bg-gradient-to-br from-gray-900 to-black text-white relative overflow-hidden shadow-2xl">
            <!-- Background Glow -->
            <div class="absolute -right-20 -top-20 w-96 h-96 bg-primary/20 rounded-full blur-3xl opacity-50"></div>
            <div class="absolute -left-20 -bottom-20 w-80 h-80 bg-blue-600/10 rounded-full blur-3xl opacity-30"></div>
            
            <div class="relative z-10 space-y-4 max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 rounded-full text-[11px] font-bold uppercase tracking-widest text-primary-fixed">
                    <span class="material-symbols-outlined text-[14px]">bolt</span>
                    System Status: Operational
                </div>
                <h1 class="text-4xl md:text-5xl font-black tracking-tight leading-tight">
                    Welcome back, <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-blue-400">{{ explode(' ', auth()->user()->name)[0] }}</span>.
                </h1>
                <p class="text-lg text-gray-400 font-medium leading-relaxed">
                    Your AI companion has been busy. We've processed 4 tasks across your active projects while you were away.
                </p>
            </div>
            
            <div class="relative z-10 hidden lg:block">
                <div class="glass-panel p-6 rounded-[2rem] border border-white/10 shadow-xl flex items-center gap-4 animate-float">
                    <div class="w-14 h-14 rounded-2xl bg-primary flex items-center justify-center shadow-lg shadow-primary/30">
                        <span class="material-symbols-outlined text-3xl">psychology</span>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Active Intelligence</p>
                        <p class="text-xl font-black text-white">4 Pending Tasks</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        <!-- Active Projects -->
        <x-card class="lg:col-span-2 relative overflow-hidden">
            <div class="flex items-center justify-between gap-4 mb-8">
                <div>
                    <h2 class="text-2xl font-black text-gray-900 tracking-tight">Active Projects</h2>
                    <p class="mt-1 text-sm font-medium text-gray-500">Track your ongoing autonomous workflows.</p>
                </div>
                <x-button variant="ghost" href="{{ route('projects.index') }}">
                    View all
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </x-button>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                @foreach (($projects ?? collect()) as $p)
                    <a href="{{ route('projects.show', $p) }}" class="group relative p-6 rounded-3xl bg-gray-50 border border-gray-100 transition-all duration-300 hover:bg-white hover:border-primary/20 hover:shadow-xl hover:shadow-primary/5">
                        <div class="flex items-start justify-between gap-3 mb-6">
                            <div class="h-12 w-12 rounded-2xl bg-white shadow-sm flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-[28px]">folder</span>
                            </div>
                            <x-badge status="active">Active</x-badge>
                        </div>
                        <div class="min-w-0">
                            <div class="truncate text-lg font-bold text-gray-900 group-hover:text-primary transition-colors">{{ $p['name'] }}</div>
                            <div class="mt-1 text-sm font-medium text-gray-500 flex items-center gap-2">
                                <span class="material-symbols-outlined text-[16px]">domain</span>
                                {{ $p['domain'] ?? 'General' }}
                            </div>
                        </div>
                    </a>
                @endforeach

                @if (($projects ?? collect())->isEmpty())
                    <div class="flex flex-col items-center justify-center p-12 rounded-3xl bg-gray-50 border border-dashed border-gray-200 text-center sm:col-span-2">
                        <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 mb-4">
                            <span class="material-symbols-outlined text-3xl">add_card</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">No active projects</h3>
                        <p class="text-sm text-gray-500 max-w-xs mt-2">Complete your onboarding to hire your first Business Companion.</p>
                        <x-button href="{{ route('onboarding.role') }}" class="mt-6">Hire a Companion</x-button>
                    </div>
                @endif
            </div>
        </x-card>

        <!-- AI Insights -->
        <x-card class="bg-primary/5 border-primary/10">
            <div class="flex items-center gap-3 mb-2">
                <span class="material-symbols-outlined text-primary text-[28px]">auto_awesome</span>
                <h2 class="text-2xl font-black text-gray-900 tracking-tight">AI Insights</h2>
            </div>
            <p class="text-sm font-medium text-gray-500 mb-8">Strategically distilled suggestions.</p>

            <div class="space-y-4">
                <div class="group p-5 rounded-2xl bg-white border border-gray-100 shadow-sm hover:border-primary/20 transition-all">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></div>
                        <span class="text-[10px] font-bold text-primary uppercase tracking-[0.1em]">Next best action</span>
                    </div>
                    <p class="text-[15px] font-bold text-gray-900 leading-snug">Draft a launch checklist for Acme and assign owners based on task history.</p>
                </div>
                
                <div class="group p-5 rounded-2xl bg-white border border-gray-100 shadow-sm hover:border-red-100 transition-all">
                    <div class="flex items-center gap-2 mb-2 text-red-500">
                        <span class="material-symbols-outlined text-[16px]">report_problem</span>
                        <span class="text-[10px] font-bold uppercase tracking-[0.1em]">Risk identified</span>
                    </div>
                    <p class="text-[15px] font-bold text-gray-900 leading-snug">Northstar dependencies are unclear. Add a logic-gate to blocking tasks.</p>
                </div>
            </div>

            <div class="mt-10">
                @php $firstProject = ($projects ?? collect())->first(); @endphp
                @if ($firstProject)
                    <x-button href="{{ route('projects.show', $firstProject) }}" class="w-full">
                        <span class="material-symbols-outlined">chat</span>
                        Open Project Chat
                    </x-button>
                @else
                    <x-button href="{{ route('onboarding.role') }}" class="w-full">
                        <span class="material-symbols-outlined">rocket_launch</span>
                        Ready to Start?
                    </x-button>
                @endif
            </div>
        </x-card>

        <!-- Recent Activity -->
        <x-card class="lg:col-span-3">
            <div class="flex items-center justify-between gap-4 mb-8">
                <div>
                    <h2 class="text-2xl font-black text-gray-900 tracking-tight">Recent Activity</h2>
                    <p class="mt-1 text-sm font-medium text-gray-500">Your companion's most recent accomplishments.</p>
                </div>
                <x-button variant="outline">
                    <span class="material-symbols-outlined text-[18px]">history</span>
                    Full Logs
                </x-button>
            </div>

            <div class="divide-y divide-gray-50 bg-gray-50/50 rounded-3xl border border-gray-100 overflow-hidden">
                <div class="p-8 text-center">
                    <span class="material-symbols-outlined text-4xl text-gray-300 mb-4 block">inventory_2</span>
                    <p class="text-sm font-semibold text-gray-500">Activity logs will appear here once your companion starts executing tasks.</p>
                </div>
            </div>
        </x-card>
    </div>

    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
    </style>
@endsection

