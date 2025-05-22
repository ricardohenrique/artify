<?php

namespace App\Http\Controllers;

use App\Models\Painting;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $mostLiked = Painting::with(['images', 'category', 'favoritedBy'])
            ->withCount('favoritedBy')
            ->orderByDesc('favorited_by_count')
            ->limit(4)
            ->get();

        $mostRecent = Painting::with(['images', 'category', 'favoritedBy'])
            ->withCount('favoritedBy')
            ->latest()
            ->limit(4)
            ->get();

        // Mock Featured Artists
        $featuredArtists = collect([
            (object)[ 'id' => 1, 'name' => 'Ava Monroe', 'location' => 'Lisbon', 'avatar_url' => null ],
            (object)[ 'id' => 2, 'name' => 'Leo Tanaka', 'location' => 'Tokyo', 'avatar_url' => null ],
            (object)[ 'id' => 3, 'name' => 'Ella Smith', 'location' => 'Berlin', 'avatar_url' => null ],
            (object)[ 'id' => 4, 'name' => 'Mateo Ruiz', 'location' => 'Buenos Aires', 'avatar_url' => null ],
        ]);

        // Mock Testimonials
        $testimonials = collect([
            (object)[ 'author' => 'Isabelle, France', 'content' => 'Buying on Artify felt personal — I love the direct connection with the artist.' ],
            (object)[ 'author' => 'Devon, UK', 'content' => 'Great quality art and easy to navigate. This is the Etsy of original paintings!' ],
            (object)[ 'author' => 'Andre, Brazil', 'content' => 'I sold my first piece last week. The platform is beautiful and simple!' ],
        ]);

        $categories = Category::withCount('paintings')
                ->orderByDesc('paintings_count')
                ->take(8)
                ->get();

        return view('home', [
            'mostLiked' => $mostLiked,
            'mostRecent' => $mostRecent,
            'featuredArtists' => $featuredArtists,
            'testimonials' => $testimonials,
            'categories' => $categories,
        ]);
    }
}
