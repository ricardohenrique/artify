<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;

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

    public function getUserById(string $id): User
    {
        return User::withCount(['followers', 'following'])->findOrFail($id);
    }

    public function getUserWithInboxRelations(int $id): User
    {
        return User::with([
            'favorites.images',
            'favorites.user',
            'followers',
            'following',
        ])
        ->withCount([
            'followers',
            'following',
            'favorites',
        ])
        ->findOrFail($id);
    }
}
