<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voice;
use App\Services\VoiceSampleGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminVoiceController extends Controller
{
    public const PROVIDERS = [
        '11labs' => 'ElevenLabs',
        'openai' => 'OpenAI',
        'azure' => 'Microsoft Azure',
        'playht' => 'PlayHT',
        'cartesia' => 'Cartesia',
        'deepgram' => 'Deepgram',
        'google' => 'Google',
        'vapi' => 'Vapi',
    ];

    public function index()
    {
        $voices = Voice::orderBy('sort_order')->orderBy('name')->get();

        return view('admin.voices.index', [
            'activeNav' => 'voices',
            'pageTitle' => 'Voice Library',
            'voices' => $voices,
        ]);
    }

    public function create()
    {
        return view('admin.voices.create', [
            'activeNav' => 'voices',
            'pageTitle' => 'Add Voice',
            'providers' => self::PROVIDERS,
        ]);
    }

    public function store(Request $request, VoiceSampleGenerator $generator)
    {
        $data = $this->validateVoice($request);

        $voice = Voice::create([
            'name' => $data['name'],
            'vapi_voice_id' => $data['vapi_voice_id'],
            'provider' => $data['provider'],
            'gender' => $data['gender'] ?: null,
            'accent' => $data['accent'] ?: null,
            'description' => $data['description'] ?: null,
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        if ($request->hasFile('avatar')) {
            $voice->avatar_path = $request->file('avatar')->store('voice-avatars', 'public');
        }

        $voice->save();

        $samplePath = app(VoiceSampleGenerator::class)->generate($voice);
        if ($samplePath) {
            $voice->update(['sample_path' => $samplePath]);
        }

        return redirect()
            ->route('admin.voices.edit', $voice)
            ->with('success', 'Voice "' . $voice->name . '" created' . ($samplePath ? ' with sample.' : '.'));
    }

    public function edit(Voice $voice)
    {
        return view('admin.voices.edit', [
            'activeNav' => 'voices',
            'pageTitle' => 'Edit Voice — ' . $voice->name,
            'voice' => $voice,
            'providers' => self::PROVIDERS,
        ]);
    }

    public function update(Request $request, Voice $voice)
    {
        $data = $this->validateVoice($request, $voice);

        $voice->fill([
            'name' => $data['name'],
            'vapi_voice_id' => $data['vapi_voice_id'],
            'provider' => $data['provider'],
            'gender' => $data['gender'] ?: null,
            'accent' => $data['accent'] ?: null,
            'description' => $data['description'] ?: null,
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        if ($request->hasFile('avatar')) {
            if ($voice->avatar_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($voice->avatar_path);
            }
            $voice->avatar_path = $request->file('avatar')->store('voice-avatars', 'public');
        }

        if ($request->hasFile('sample')) {
            if ($voice->sample_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($voice->sample_path);
            }
            $voice->sample_path = $request->file('sample')->store('voice-samples', 'public');
        }

        $voice->save();

        return redirect()
            ->route('admin.voices.index')
            ->with('success', 'Voice "' . $voice->name . '" updated.');
    }

    public function generateSample(Request $request, Voice $voice)
    {
        $path = app(VoiceSampleGenerator::class)->generate($voice);

        if (!$path) {
            return back()->with('error', 'Could not generate a sample for this voice. Check the provider API key.');
        }

        $voice->update(['sample_path' => $path]);

        return back()->with('success', 'Voice sample generated for "' . $voice->name . '".');
    }

    public function destroy(Voice $voice)
    {
        if ($voice->avatar_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($voice->avatar_path);
        }
        if ($voice->sample_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($voice->sample_path);
        }

        $voice->delete();

        return back()->with('success', 'Voice deleted.');
    }

    public function toggle(Voice $voice)
    {
        $voice->update(['is_active' => !$voice->is_active]);

        return back()->with('success', $voice->is_active ? 'Voice activated.' : 'Voice deactivated.');
    }

    private function validateVoice(Request $request, ?Voice $voice = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'vapi_voice_id' => [
                'required', 'string', 'max:255',
                Rule::unique('voices', 'vapi_voice_id')->ignore($voice?->id),
            ],
            'provider' => ['required', Rule::in(array_keys(self::PROVIDERS))],
            'gender' => ['nullable', 'string', 'max:20'],
            'accent' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'sample' => ['nullable', 'file', 'mimes:mp3,wav,ogg,m4a', 'max:5120'],
        ]);
    }
}