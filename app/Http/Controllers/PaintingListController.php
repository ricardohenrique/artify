<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Painting;
use Illuminate\Http\Request;

class PaintingListController extends Controller
{
    public function explore(Request $request, string $categorySlug = null)
    {
        $categories = Category::withCount('paintings')
            ->orderByDesc('paintings_count')
            ->get();

        $sort = $request->input('sort', 'newest');
        $price = $request->input('price');

        // Use all paintings if no category is selected
        $query = Painting::with(['images', 'category'])
            ->withCount('favoritedBy');

        if ($categorySlug) {
            $category = Category::where('slug', $categorySlug)->firstOrFail();
            $query->where('category_id', $category->id);
        }

        // Apply price filter if present
        if ($price && str_starts_with($price, 'between-')) {
            [$from, $to] = explode('-', str_replace('between-', '', $price));
            $query->whereBetween('price', [(float)$from, (float)$to]);
        }

        switch ($sort) {
            case 'liked':
                $query->orderByDesc('favorited_by_count');
                break;
            case 'cheap':
                $query->orderBy('price');
                break;
            case 'newest':
            default:
                $query->latest();
                break;
        }

        $paintings = $query->paginate(8)->withQueryString();

        if (!isset($category)) {
            $category = new Category([
                'name' => 'independent artwork',
            ]);
        }

        return view('painting.list', [
            'category' => $category,
            'categories' => $categories,
            'paintings' => $paintings,
            'selectedSort' => $sort,
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        $paintings = Painting::with(['images', 'category'])
            ->withCount('favoritedBy')
            ->where('title', 'like', '%' . $query . '%')
            ->orWhere('description', 'like', '%' . $query . '%')
            ->latest()
            ->paginate(12);

        return view('painting.search', [
            'paintings' => $paintings,
            'query' => $query,
        ]);
    }
}
