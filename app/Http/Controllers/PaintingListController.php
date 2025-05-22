<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class PaintingListController extends Controller
{
    public function paintings(Request $request, string $categorySlug)
    {
        $category = Category::where('slug', $categorySlug)->firstOrFail();
        $categories = Category::withCount('paintings')
        ->orderByDesc('paintings_count')
        ->get();

        $sort = $request->input('sort', 'newest'); // default sort

        $query = $category->paintings()
            ->with(['images'])
            ->withCount('favoritedBy');

        // Apply sorting
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

        return view('painting.list', [
            'category' => $category,
            'categories' => $categories,
            'paintings' => $paintings,
            'selectedSort' => $sort,
        ]);
    }
}
