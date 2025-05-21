<?php

namespace App\Http\Controllers;

use App\Models\Painting;

class HomeController extends Controller
{
    public function index()
    {
        $mostLiked = Painting::with(['images', 'category', 'favoritedBy'])
            ->withCount('favoritedBy')
            ->orderByDesc('favorited_by_count')
            ->limit(8)
            ->get();

        $mostRecent = Painting::with(['images', 'category', 'favoritedBy'])
            ->withCount('favoritedBy')
            ->latest()
            ->limit(8)
            ->get();

        return view('home', [
            'mostLiked' => $mostLiked,
            'mostRecent' => $mostRecent,
        ]);
    }
}
