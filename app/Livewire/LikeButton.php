<?php

namespace App\Livewire;

use App\Models\Painting;
use App\Models\User;
use App\Services\PaintingService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LikeButton extends Component
{
    public Painting $painting;
    public bool     $isFavorited    = false;
    public bool     $hasLikes       = false;
    public ?int     $favoriteCount  = 0;

    public function mount()
    {
        $this->updateLikeState();
    }

    protected function paintingService(): PaintingService
    {
        return app(PaintingService::class);
    }

    public function toggleFavorite()
    {
        /** @var User $user */
        $user = Auth::user();

        $this->paintingService()->toggleFavorite($user, $this->painting);
        $this->painting->refresh();
        $this->updateLikeState();
    }

    public function render()
    {
        $data = [
            'hasLikes' => $this->hasLikes,
            'isFavorited' => $this->isFavorited,
            'favoriteCount' => $this->favoriteCount
        ];

        return view('livewire.like-button', $data);
    }

    protected function updateLikeState(): void
    {
        $this->isFavorited = Auth::check() && Auth::user()->favorites->contains($this->painting->id);
        $this->hasLikes = $this->painting->favorited_by_count > 0;
        $this->favoriteCount = $this->painting->favorited_by_count;
    }
}