<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $name = $googleUser->getName();
        $email = $googleUser->getEmail();

        // Check if the user already exists
        $user = User::where('email', $email)->first();

        if ($user) {
            // User exists: update only safe fields
            $user->update([
                'name' => $name,
                'slug' => $user->slug ?? Str::slug($name . '-' . uniqid()),
                'google_id' => $googleUser->getId(),
                'email_verified_at' => now(),
            ]);
        } else {
            // User does not exist: create a new one with user_type
            $user = User::create([
                'name' => $name,
                'slug' => Str::slug($name . '-' . uniqid()),
                'email' => $email,
                'google_id' => $googleUser->getId(),
                'email_verified_at' => now(),
                'user_type' => 2,
            ]);
        }

        Auth::login($user, true);

        // Redirect logic based on user type
        switch ($user->user_type_id ?? $user->user_type) {
            case 1:
                return redirect()->intended(route('member.profile', ['id' => $user->id]));
            case 2:
                return redirect()->intended(route('member.profile', ['id' => $user->id]));
            case 3:
                return redirect()->intended(route('dashboard'));
            default:
                return redirect()->intended(route('member.profile', ['id' => $user->id]));
        }
    }
}
