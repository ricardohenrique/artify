<?php

namespace App\Http\Controllers;

use App\Models\Category;

class PaintingListController extends Controller
{
    public function paintings(Category $category)
    {
        // Load the paintings (eager-load if needed)
        $paintings = $category->paintings()->latest()->paginate(12);

        return view('painting.list', [
            'category' => $category,
            'paintings' => $paintings,
        ]);
    }
}
