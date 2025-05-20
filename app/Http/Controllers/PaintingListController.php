<?php

namespace App\Http\Controllers;

use App\Models\Category;

class PaintingListController extends Controller
{
    public function paintings(string $categorySlug)
    {
        $category = Category::where('slug', $categorySlug)->firstOrFail();

        $paintings = $category->paintings()
        ->withCount('favoritedBy')
        ->with('images')
        ->latest()
        ->paginate(12);

        return view('painting.list', [
            'category' => $category,
            'paintings' => $paintings,
        ]);
    }
}
