<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    protected CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getCategoryWithPaintingCount($quantity)
    {
        return $this->categoryRepository->getCategoryWithPaintingCount($quantity);
    }

    public function getAllOrderedByPaintingCount(): Collection
    {
        return $this->categoryRepository->getAllOrderedByPaintingCount();
    }

    public function findBySlug(string $slug): ?Category
    {
        return $this->categoryRepository->findBySlug($slug);
    }
}
