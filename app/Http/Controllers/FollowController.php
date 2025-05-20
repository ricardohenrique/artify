<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class FollowController extends Controller
{
    public function toggle(User $user)
    {
        $authUser = auth()->user();
        
        if ($authUser->id === $user->id) {
            return back()->with('error', 'You cannot follow yourself.');
        }

        if ($authUser->following()->where('user_id', $user->id)->exists()) {
            $authUser->following()->detach($user->id);
        } else {
            $authUser->following()->attach($user->id);
        }

        return back();
    }
}
