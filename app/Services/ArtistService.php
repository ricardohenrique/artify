<?php

namespace App\Services;

use App\Repositories\ArtistRepository;

class ArtistService
{
    protected ArtistRepository $artistRepository;

    public function __construct(ArtistRepository $artistRepository)
    {
        $this->artistRepository = $artistRepository;
    }

    public function getArtistsForListing($perPage = 12)
    {
        return $this->artistRepository->getPaginatedArtistsWithCounts($perPage);
    }

    public function getArtistBySlug(string $slug)
    {
        return $this->artistRepository->getArtistBySlug($slug);
    }
}
