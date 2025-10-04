<?php

namespace App\Http\Controllers;

use App\Models\Painting;
use App\Models\Category;
use App\Services\PaintingService;
use App\Services\CategoryService;

class HomeController extends Controller
{
    protected PaintingService $paintingService;

    protected CategoryService $categoryService;

    public function __construct(PaintingService $paintingService, CategoryService $categoryService)
    {
        $this->paintingService = $paintingService;
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $mostLiked = $this->paintingService->getMostLikedPaintings(5);

        $mostRecent = $this->paintingService->getMostRecentPaintings(5);

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

        $categories = $this->categoryService->getCategoryWithPaintingCount(8);

        return view('home', [
            'mostLiked' => $mostLiked,
            'mostRecent' => $mostRecent,
            'featuredArtists' => $featuredArtists,
            'testimonials' => $testimonials,
            'categories' => $categories,
        ]);
    }
}
