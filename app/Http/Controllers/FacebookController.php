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
        return Socialite::driver('facebook')->scopes(['email'])->redirect();
    }

    public function callback()
    {
        $facebookUser = Socialite::driver('facebook')->stateless()->user();
        $name = $facebookUser->getName();

        $user = User::updateOrCreate(
            ['email' => $facebookUser->getEmail()],
            [
                'name' => $name,
                'slug' => Str::slug($name . '-' . uniqid()),
                'facebook_id' => $facebookUser->getId(),
                'email_verified_at' => now(),
                'password' => bcrypt(Str::random(16)),
                'user_type' => 2,
            ]
        );

        Auth::login($user, true);

        return redirect()->intended(route('dashboard'));
    }
}
