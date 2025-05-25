<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Painting;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    public function index(string $artistSlug)
    {
        $artist = User::where('slug', $artistSlug)->firstOrFail();

        $paintings = Painting::with(['images', 'category'])
            ->withCount('favoritedBy')
            ->where('user_id', $artist->id)
            // ->where('is_draft', false)
            ->latest()
            ->paginate(8);

        return view('painting.artist', [
            'artist' => $artist,
            'paintings' => $paintings,
        ]);
    }
}
