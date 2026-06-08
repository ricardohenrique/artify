<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\CategoryService;
use App\Services\PaintingService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaintingListController extends Controller
{
    public function __construct(
        private readonly PaintingService $paintingService,
        private readonly CategoryService $categoryService,
    ) {}

    public function explore(Request $request, string $categorySlug = null): View
    {
        $categories = $this->categoryService->getAllOrderedByPaintingCount();

        $sort = $request->input('sort', 'newest');
        $price = $request->input('price');

        $category = null;

        if ($categorySlug) {
            $category = $this->categoryService->findBySlug($categorySlug);

            if (!$category) {
                abort(404);
            }
        }

        $paintings = $this->paintingService->getExplorePaintings($category?->id, $price, $sort);

        if (!$category) {
            $category = new Category(['name' => 'independent artwork']);
        }

        return view('painting.list', [
            'category' => $category,
            'categories' => $categories,
            'paintings' => $paintings,
            'selectedSort' => $sort,
        ]);
    }

    public function search(Request $request): View
    {
        $query = $request->input('q', '');

        $paintings = $this->paintingService->searchPaintings($query);

        return view('painting.search', [
            'paintings' => $paintings,
            'query' => $query,
        ]);
    }
}
