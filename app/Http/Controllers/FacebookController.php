<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback()
    {
        $facebookUser = Socialite::driver('facebook')->stateless()->user();

        $user = User::updateOrCreate(
            ['email' => $facebookUser->getEmail()],
            [
                'name' => $facebookUser->getName(),
                'facebook_id' => $facebookUser->getId(),
                'email_verified_at' => now(),
                'password' => bcrypt(Str::random(16)),
            ]
        );

        Auth::login($user, true);

        return redirect()->intended(route('dashboard'));
    }
}
