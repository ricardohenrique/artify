<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Painting;
use App\Repositories\PaintingRepository;
use App\Services\ArtistService;
use App\Services\PaintingService;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    protected ArtistService $artistService;
    protected PaintingService $paintingService;

    public function __construct(ArtistService $artistService, PaintingService $paintingService)
    {
        $this->artistService = $artistService;
        $this->paintingService = $paintingService;
    }

    public function index()
    {
        $artists = $this->artistService->getArtistsForListing();

        return view('artist.list', [
            'artists' => $artists,
        ]);
    }

    public function show(string $artistSlug)
    {
        $artist = $this->artistService->getArtistBySlug($artistSlug);
        $paintings = $this->paintingService->getPaintingsByArtistId($artist->id);

        return view('artist.show', [
            'artist' => $artist,
            'paintings' => $paintings,
        ]);
    }
}
