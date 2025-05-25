<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\User;

class FollowButton extends Component
{
    public User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function render(): View|Closure|string
    {
        return view('components.follow-button');
    }
}
