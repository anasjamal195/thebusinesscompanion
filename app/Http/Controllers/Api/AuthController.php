<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user = Auth::user();
        $token = $user->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        $token = $user->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ], 201);
    }

    public function googleLogin(Request $request)
    {
        $request->validate([
            'id_token' => ['required', 'string'],
        ]);

        $response = Http::timeout(15)
            ->get('https://oauth2.googleapis.com/tokeninfo', [
                'id_token' => $request->input('id_token'),
            ]);

        if ($response->failed()) {
            throw ValidationException::withMessages([
                'id_token' => ['The Google token is invalid or expired.'],
            ]);
        }

        $info = $response->json();

        $allowedAudiences = array_values(array_filter([
            config('services.google.web_client_id'),
            config('services.google.android_client_id'),
        ]));

        if ($allowedAudiences && !in_array($info['aud'] ?? null, $allowedAudiences, true)) {
            throw ValidationException::withMessages([
                'id_token' => ['The Google token audience is not recognized.'],
            ]);
        }

        if (!filter_var($info['email_verified'] ?? false, FILTER_VALIDATE_BOOLEAN) || empty($info['email'])) {
            throw ValidationException::withMessages([
                'id_token' => ['The Google account email is not verified.'],
            ]);
        }

        $googleId = $info['sub'];
        $email = $info['email'];
        $name = $info['name'] ?? null;
        $avatar = $info['picture'] ?? null;

        $user = User::where('google_id', $googleId)->first()
            ?? User::where('email', $email)->first();

        if ($user) {
            $user->update([
                'google_id' => $googleId,
                'name' => $name ?: $user->name,
                'avatar' => $avatar ?: $user->avatar,
            ]);
        } else {
            $user = User::create([
                'name' => $name ?: 'Google User',
                'email' => $email,
                'google_id' => $googleId,
                'avatar' => $avatar,
                'password' => Hash::make(Str::password(32)),
            ]);
        }

        $token = $user->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully.']);
    }

    public function user(Request $request)
    {
        $user = $request->user()->load('profile');
        return response()->json(['user' => $user]);
    }
}
