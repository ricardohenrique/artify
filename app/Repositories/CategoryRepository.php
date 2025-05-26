<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    public function getCategoryWithPaintingCount($quantity)
    {
        return Category::withCount('paintings')
        ->orderByDesc('paintings_count')
        ->take($quantity)
        ->get();
    }
}
