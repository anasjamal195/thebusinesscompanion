<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleSocialiteController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')
            ->redirectUrl(route('google.callback'))
            ->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')
                ->redirectUrl(route('google.callback'))
                ->user();
        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            \Illuminate\Support\Facades\Log::warning(
                'Google OAuth invalid state',
                ['url' => request()->fullUrl()]
            );

            return redirect()->route('login')->withErrors([
                'google' => 'Google sign-in session expired. Please try again.',
            ]);
        }

        $user = User::where('google_id', $googleUser->getId())->first();

        if (!$user) {
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]);
            } else {
                $name = $googleUser->getName();
                $baseEmail = $googleUser->getEmail();
                $email = $baseEmail;
                $suffix = 1;

                while (User::where('email', $email)->exists()) {
                    $email = Str::before($baseEmail, '@') . "+{$suffix}@" . Str::after($baseEmail, '@');
                    $suffix++;
                }

                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => Hash::make(Str::password(32)),
                ]);
            }
        }

        Auth::login($user);
        request()->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }
}
