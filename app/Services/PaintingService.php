<?php

namespace App\Services;

use App\Models\Painting;
use App\Models\User;
use App\Repositories\PaintingRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class PaintingService
{
    protected PaintingRepository $paintingRepository;

    public function __construct(PaintingRepository $paintingRepository)
    {
        $this->paintingRepository = $paintingRepository;
    }

    public function getPaintingsByArtistId(int $artistId, $perPage = 12): LengthAwarePaginator
    {
        return $this->paintingRepository->getPaintingsByArtistId($artistId, $perPage);
    }

    public function toggleFavorite(User $user, Painting $painting): void
    {
        $this->paintingRepository->toggleFavorite($user, $painting);
    }
}
