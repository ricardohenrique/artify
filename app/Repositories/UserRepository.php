<?php

namespace App\Repositories;

use App\Models\Painting;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository
{
    public function toggleFollow(User $user, User $followedUser): void
    {
        if ($user->following()->where('user_id', $followedUser->id)->exists()) {
            $user->following()->detach($followedUser->id);
        } else {
            $user->following()->attach($followedUser->id);
        }
    }

    public function getUserById(string $id)
    {
        return User::withCount(['followers', 'following'])->findOrFail($id);
    }
}
