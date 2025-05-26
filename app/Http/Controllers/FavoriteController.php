<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\PaintingService;
use App\Models\Painting;

class FavoriteController extends Controller
{
    protected PaintingService $paintingService;

    public function __construct(PaintingService $paintingService)
    {
        $this->paintingService = $paintingService;
    }

    public function toggle(Painting $painting)
    {
        /** @var User $user */
        $user = auth()->user();

        $this->paintingService->toggleFavorite($user, $painting);

        return back();
    }
}
