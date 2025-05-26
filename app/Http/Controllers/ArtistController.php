<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Painting;
use App\Repositories\PaintingRepository;
use App\Services\ArtistService;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    protected ArtistService $artistService;
    protected PaintingRepository $paintingService;

    public function __construct(ArtistService $artistService, PaintingRepository $paintingService)
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
