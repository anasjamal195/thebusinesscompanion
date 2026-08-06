@extends('admin.layouts.app', ['title' => 'Voice Library', 'activeNav' => 'voices', 'pageTitle' => 'Voice Library'])

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-gray-500">Voices shown in the app's onboarding & settings. Powered by Vapi.</p>
    <a href="{{ route('admin.voices.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2.5 text-sm font-semibold text-white hover:bg-primary/90 transition-all">
        <span class="material-symbols-outlined text-[18px]">add</span>
        Add Voice
    </a>
</div>

<div class="rounded-xl border border-gray-200 bg-white overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="text-left text-[11px] font-semibold uppercase tracking-wider text-gray-500 px-5 py-3.5">Voice</th>
                    <th class="text-left text-[11px] font-semibold uppercase tracking-wider text-gray-500 px-5 py-3.5">Vapi ID</th>
                    <th class="text-left text-[11px] font-semibold uppercase tracking-wider text-gray-500 px-5 py-3.5">Provider</th>
                    <th class="text-left text-[11px] font-semibold uppercase tracking-wider text-gray-500 px-5 py-3.5">Gender</th>
                    <th class="text-left text-[11px] font-semibold uppercase tracking-wider text-gray-500 px-5 py-3.5">Accent</th>
                    <th class="text-center text-[11px] font-semibold uppercase tracking-wider text-gray-500 px-5 py-3.5">Sample</th>
                    <th class="text-center text-[11px] font-semibold uppercase tracking-wider text-gray-500 px-5 py-3.5">Status</th>
                    <th class="text-right text-[11px] font-semibold uppercase tracking-wider text-gray-500 px-5 py-3.5">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($voices as $voice)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                @if ($voice->avatar_path)
                                    <img src="{{ $voice->avatar_url }}" class="h-10 w-10 rounded-full object-cover border border-gray-200" alt="{{ $voice->name }}" />
                                @else
                                    <div class="h-10 w-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-sm">
                                        {{ substr($voice->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="text-sm font-semibold text-gray-900">{{ $voice->name }}</div>
                                    @if ($voice->description)
                                        <div class="text-[11px] text-gray-400">{{ $voice->description }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <code class="rounded-md bg-gray-100 px-2 py-1 text-[11px] text-gray-600">{{ $voice->vapi_voice_id }}</code>
                        </td>
                        <td class="px-5 py-4 text-sm text-gray-600">{{ $voice->provider }}</td>
                        <td class="px-5 py-4 text-sm text-gray-600">{{ $voice->gender ?? '—' }}</td>
                        <td class="px-5 py-4 text-sm text-gray-600">{{ $voice->accent ?? '—' }}</td>
                        <td class="px-5 py-4">
                            <div class="flex flex-col items-center gap-1.5">
                                @if ($voice->sample_path)
                                    <audio controls preload="none" class="h-8 w-36">
                                        <source src="{{ $voice->sample_url }}" type="audio/mpeg">
                                    </audio>
                                @else
                                    <span class="text-xs text-gray-400">No sample</span>
                                @endif
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] font-semibold {{ str_contains($engines[$voice->id] ?? '', 'fallback') ? 'text-amber-600' : 'text-green-600' }}">
                                        {{ $engines[$voice->id] ?? '' }}
                                    </span>
                                    <form method="POST" action="{{ route('admin.voices.sample', $voice) }}" class="inline">
                                        @csrf
                                        <button type="submit" title="Generate sample" class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-gray-100 text-gray-500 hover:bg-primary/10 hover:text-primary transition-colors">
                                            <span class="material-symbols-outlined text-[16px]">refresh</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex justify-center">
                                <form method="POST" action="{{ route('admin.voices.toggle', $voice) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold {{ $voice->is_active ? 'bg-green-50 text-green-700 hover:bg-green-100' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }} transition-colors">
                                        <span class="h-1.5 w-1.5 rounded-full {{ $voice->is_active ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                                        {{ $voice->is_active ? 'Active' : 'Inactive' }}
                                    </button>
                                </form>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.voices.edit', $voice) }}" class="inline-flex h-8 items-center gap-1.5 rounded-lg px-3 text-xs font-semibold text-primary hover:bg-primary/10 transition-colors">
                                    <span class="material-symbols-outlined text-[16px]">edit</span>
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.voices.destroy', $voice) }}" class="inline"
                                    onsubmit="return confirm('Delete {{ $voice->name }}? This cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex h-8 items-center rounded-lg px-2.5 text-xs font-semibold text-red-500 hover:bg-red-50 transition-colors">
                                        <span class="material-symbols-outlined text-[16px]">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-5 py-10 text-center text-sm text-gray-500">
                            No voices yet. <a href="{{ route('admin.voices.create') }}" class="font-semibold text-primary">Add your first voice</a>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection