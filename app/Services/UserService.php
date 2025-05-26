<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;

class UserService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function toggleFollow(User $user, User $followedUser): void
    {
        $this->userRepository->toggleFollow($user, $followedUser);
    }
}
