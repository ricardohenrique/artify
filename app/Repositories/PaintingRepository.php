<?php

namespace App\Repositories;

use App\Models\Painting;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class PaintingRepository
{
    public function getPaintingsByArtistId(int $artistId, $perPage = 12): LengthAwarePaginator
    {
        return Painting::with(['images', 'category'])
            ->withCount('favoritedBy')
            ->where('user_id', $artistId)
            ->latest()
            ->paginate($perPage);
    }

    public function toggleFavorite(User $user, Painting $painting): void
    {
        if ($user->favorites()->where('painting_id', $painting->id)->exists()) {
            $user->favorites()->detach($painting->id);
        } else {
            $user->favorites()->attach($painting->id);
        }
    }
}
