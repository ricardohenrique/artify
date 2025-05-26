<?php

namespace App\Repositories;

use App\Models\Painting;

class PaintingRepository
{
    public function getPaintingsByArtistId(int $artistId, $perPage = 12)
    {
        return Painting::with(['images', 'category'])
            ->withCount('favoritedBy')
            ->where('user_id', $artistId)
            ->latest()
            ->paginate($perPage);
    }
}
