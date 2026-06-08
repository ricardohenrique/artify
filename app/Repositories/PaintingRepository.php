<?php

declare(strict_types=1);

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

    public function getMostLikedPaintings(int $quantity)
    {
        return Painting::with(['images', 'category', 'favoritedBy'])
        ->where('is_draft', false)
        ->withCount('favoritedBy')
        ->orderByDesc('favorited_by_count')
        ->limit($quantity)
        ->get();
    }

    public function getMostRecentPaintings(int $quantity)
    {
        return Painting::with(['images', 'category', 'favoritedBy'])
        ->where('is_draft', false)
        ->withCount('favoritedBy')
        ->latest()
        ->limit($quantity)
        ->get();
    }

    public function getFilteredPaintings(
        ?int $categoryId,
        ?float $priceFrom,
        ?float $priceTo,
        string $sort,
        int $perPage = 10
    ): LengthAwarePaginator {
        $query = Painting::with(['images', 'category'])
            ->withCount('favoritedBy')
            ->where('is_draft', false);

        if ($categoryId !== null) {
            $query->where('category_id', $categoryId);
        }

        if ($priceFrom !== null && $priceTo !== null) {
            $query->whereBetween('price', [$priceFrom, $priceTo]);
        }

        switch ($sort) {
            case 'liked':
                $query->orderByDesc('favorited_by_count');
                break;
            case 'cheap':
                $query->orderBy('price');
                break;
            default:
                $query->latest();
                break;
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function searchPaintings(string $term, int $perPage = 10): LengthAwarePaginator
    {
        return Painting::with(['images', 'category'])
            ->withCount('favoritedBy')
            ->where('is_draft', false)
            ->where(fn($q) => $q->where('title', 'like', "%{$term}%")
                ->orWhere('description', 'like', "%{$term}%"))
            ->latest()
            ->paginate($perPage);
    }
}
