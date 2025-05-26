<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Models\User;

class FollowController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    public function toggle(User $user)
    {
        /** @var User $authUser */
        $authUser = auth()->user();

        if ($authUser->id === $user->id) {
            return back()->with('error', 'You cannot follow yourself.');
        }

        $this->userService->toggleFollow($authUser, $user);

        return back();
    }
}
