<?php

namespace App\Repositories;

use App\Models\User;

class ArtistRepository
{
    public function getPaginatedArtistsWithCounts($perPage = 12)
    {
        return User::withCount(['paintings', 'followers'])
            ->where('user_type_id', '=', 3)
            ->latest()
            ->paginate($perPage);
    }

    public function getArtistBySlug(string $slug)
    {
        return User::where('slug', $slug)->firstOrFail();
    }
}
