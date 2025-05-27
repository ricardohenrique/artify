<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\UserService;

class FollowButton extends Component
{
    public User $user;
    public string $buttonClass = '';

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function toggleFollow()
    {
        /** @var User $authUser */
        $authUser = Auth::user();

        if ($authUser->id === $this->user->id) {
            return back()->with('error', 'You cannot follow yourself.');
        }
        app(UserService::class)->toggleFollow($authUser, $this->user);
    }

    public function render()
    {
        /** @var User $authUser */
        $authUser = Auth::user();

        $isFollowing = false;
        if ($authUser) {
            $isFollowing = $authUser->following->contains($this->user->id);
        }

        return view('livewire.follow-button', compact('isFollowing'));
    }
}
