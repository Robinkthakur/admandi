<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->to('/')->with('error', 'Google authentication failed.');
        }

        // Find or create the user securely by verified email
        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            // Update user avatar from Google if not set
            if (!$user->avatar) {
                $user->update([
                    'avatar' => $googleUser->getAvatar(),
                ]);
            }
        } else {
            // Create user
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'avatar' => $googleUser->getAvatar(),
                'email_verified_at' => now(),
                'password' => bcrypt(Str::random(32)),
            ]);
        }

        // Log the user in
        Auth::login($user, true);

        // Record User Activity
        \App\Services\ActivityLogger::log('Login', 'User logged in via Google.', $user);

        return redirect()->intended('/');
    }
}
