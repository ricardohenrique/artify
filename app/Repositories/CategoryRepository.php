<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository
{
    public function getCategoryWithPaintingCount($quantity)
    {
        return Category::withCount('paintings')
        ->orderByDesc('paintings_count')
        ->take($quantity)
        ->get();
    }

    public function getAllOrderedByPaintingCount(): Collection
    {
        return Category::withCount('paintings')
            ->orderByDesc('paintings_count')
            ->get();
    }

    public function findBySlug(string $slug): ?Category
    {
        return Category::where('slug', $slug)->first();
    }
}
