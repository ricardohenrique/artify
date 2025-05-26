<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Painting;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    public function index()
    {
        $artists = User::withCount(['paintings', 'followers'])
//            ->whereHas('paintings', function ($query) {
////                $query->where('is_draft', false);
//            })
            ->latest()
            ->paginate(12); // paginate to keep it clean

        return view('artist.list', [
            'artists' => $artists,
        ]);
    }

    public function show(string $artistSlug)
    {
        $artist = User::where('slug', $artistSlug)->firstOrFail();

        $paintings = Painting::with(['images', 'category'])
            ->withCount('favoritedBy')
            ->where('user_id', $artist->id)
            // ->where('is_draft', false)
            ->latest()
            ->paginate(8);

        return view('artist.show', [
            'artist' => $artist,
            'paintings' => $paintings,
        ]);
    }
}
