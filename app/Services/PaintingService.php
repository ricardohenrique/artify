<?php

declare(strict_types=1);

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

    public function getMostLikedPaintings(int $quantity)
    {
        return $this->paintingRepository->getMostLikedPaintings($quantity);
    }

    public function getMostRecentPaintings(int $quantity)
    {
        return $this->paintingRepository->getMostRecentPaintings($quantity);
    }

    public function getExplorePaintings(
        ?int $categoryId,
        ?string $priceFilter,
        string $sort,
        int $perPage = 10
    ): LengthAwarePaginator {
        $priceFrom = null;
        $priceTo = null;

        if ($priceFilter !== null && str_starts_with($priceFilter, 'between-')) {
            $parts = explode('-', str_replace('between-', '', $priceFilter));

            if (count($parts) === 2 && is_numeric($parts[0]) && is_numeric($parts[1])) {
                $priceFrom = (float) $parts[0];
                $priceTo = (float) $parts[1];
            }
        }

        return $this->paintingRepository->getFilteredPaintings($categoryId, $priceFrom, $priceTo, $sort, $perPage);
    }

    public function searchPaintings(string $term, int $perPage = 10): LengthAwarePaginator
    {
        return $this->paintingRepository->searchPaintings($term, $perPage);
    }
}
