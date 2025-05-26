<?php

namespace App\Services;

use App\Repositories\PaintingRepository;

class PaintingService
{
    protected PaintingRepository $paintingRepository;

    public function __construct(PaintingRepository $paintingRepository)
    {
        $this->paintingRepository = $paintingRepository;
    }

    public function getPaintingsByArtistId(int $artistId, $perPage = 12)
    {
        return $this->paintingRepository->getPaintingsByArtistId($artistId, $perPage);
    }
}
