@php
    $voice = $voice ?? null;
@endphp

<div class="rounded-xl border border-gray-200 bg-white overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200">
        <h2 class="text-sm font-bold text-gray-900">Voice Details</h2>
        <p class="mt-0.5 text-xs text-gray-400">Copy the Voice ID from the Vapi dashboard (Voice Library) — it's the identifier Vapi uses to load the voice on calls.</p>
    </div>

    <div class="p-6 space-y-5">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="text-sm font-medium text-gray-900">Name <span class="text-red-500">*</span></label>
                <input name="name" value="{{ old('name', $voice->name ?? '') }}" required placeholder="Jessica"
                    class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-primary focus:ring-primary" />
                @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-sm font-medium text-gray-900">Vapi Voice ID <span class="text-red-500">*</span></label>
                <input name="vapi_voice_id" value="{{ old('vapi_voice_id', $voice->vapi_voice_id ?? '') }}" required placeholder="cgSgspJ2msm6clMCkdW9"
                    class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm font-mono focus:border-primary focus:ring-primary" />
                @error('vapi_voice_id') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-sm font-medium text-gray-900">Provider <span class="text-red-500">*</span></label>
                <select name="provider" class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-primary focus:ring-primary">
                    @foreach ($providers as $value => $label)
                        <option value="{{ $value }}" {{ old('provider', $voice->provider ?? '11labs') === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @error('provider') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-sm font-medium text-gray-900">Gender</label>
                <select name="gender" class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-primary focus:ring-primary">
                    <option value="">— None —</option>
                    @foreach (['Female', 'Male'] as $g)
                        <option value="{{ $g }}" {{ old('gender', $voice->gender ?? '') === $g ? 'selected' : '' }}>{{ $g }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-sm font-medium text-gray-900">Accent</label>
                <input name="accent" value="{{ old('accent', $voice->accent ?? '') }}" placeholder="American, British, …"
                    class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-primary focus:ring-primary" />
            </div>

            <div>
                <label class="text-sm font-medium text-gray-900">Sort Order</label>
                <input name="sort_order" type="number" min="0" value="{{ old('sort_order', $voice->sort_order ?? 0) }}"
                    class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-primary focus:ring-primary" />
            </div>
        </div>

        <div>
            <label class="text-sm font-medium text-gray-900">Description</label>
            <textarea name="description" rows="2" placeholder="Warm & Friendly" maxlength="500"
                class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-primary focus:ring-primary">{{ old('description', $voice->description ?? '') }}</textarea>
            @error('description') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="text-sm font-medium text-gray-900">Avatar Image</label>
                <input name="avatar" type="file" accept="image/jpeg,image/png,image/webp"
                    class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-gray-100 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-gray-600 hover:file:bg-gray-200" />
                @if (isset($voice) && $voice->avatar_path)
                    <div class="mt-2 flex items-center gap-2">
                        <img src="{{ $voice->avatar_url }}" class="h-8 w-8 rounded-full object-cover border border-gray-200" alt="" />
                        <span class="text-xs text-gray-400">Current avatar</span>
                    </div>
                @endif
                @error('avatar') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            @if (isset($voice))
            <div>
                <label class="text-sm font-medium text-gray-900">Manual Sample (optional)</label>
                <input name="sample" type="file" accept="audio/mpeg,audio/wav,audio/ogg,audio/mp4"
                    class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-gray-100 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-gray-600 hover:file:bg-gray-200" />
                @if ($voice->sample_path)
                    <div class="mt-2">
                        <audio controls preload="none" class="h-8 w-56">
                            <source src="{{ $voice->sample_url }}" type="audio/mpeg">
                        </audio>
                    </div>
                @endif
                @error('sample') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>
            @endif
        </div>

        <label class="flex items-center gap-2.5 cursor-pointer">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', isset($voice) ? $voice->is_active : true) ? 'checked' : '' }}
                class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary" />
            <span class="text-sm font-medium text-gray-900">Active — visible in the app</span>
        </label>
    </div>
</div>

<div class="mt-6 flex items-center gap-3">
    <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-primary px-5 py-2.5 text-sm font-semibold text-white hover:bg-primary/90 transition-all">
        <span class="material-symbols-outlined text-[18px]">{{ isset($voice) ? 'save' : 'add' }}</span>
        {{ isset($voice) ? 'Save Changes' : 'Create Voice' }}
    </button>
    <a href="{{ route('admin.voices.index') }}" class="rounded-xl px-5 py-2.5 text-sm font-semibold text-gray-500 hover:bg-gray-100 transition-colors">Cancel</a>
</div>