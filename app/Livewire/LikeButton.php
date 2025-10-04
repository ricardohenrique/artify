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

    protected $listeners = [
        'favorite-toggled' => 'handleExternalToggle',
    ];

    public bool $isFavorited    = false;
    public bool $hasLikes       = false;
    public ?int $favoriteCount  = 0;
    public bool $positionTop    = true;
    public string $buttonType   = 'icon';

    public function mount(Painting $painting)
    {
        $this->painting = $painting;
        $this->updateLikeState();
    }

    public function handleExternalToggle(int $paintingId)
    {
        if ($paintingId !== $this->painting->id) {
            return;
        }

        // Painting was updated elsewhere, so refresh locally
        $this->painting->loadCount('favoritedBy');
        $this->updateLikeState();
    }

    protected function paintingService(): PaintingService
    {
        return app(PaintingService::class);
    }

    public function toggleFavorite()
    {
        if (!Auth::check()) {
            return;
        }

        /** @var User $user */
        $user = Auth::user();
        $this->paintingService()->toggleFavorite($user, $this->painting);
        $this->painting->loadCount('favoritedBy');
        $this->updateLikeState();

        // ✅ Broadcast to all like buttons for the same painting
        $this->dispatch('favorite-toggled', paintingId: $this->painting->id);
    }

    public function render()
    {
        return view('livewire.like-button');
    }

    protected function updateLikeState(): void
    {
        if (Auth::check()) {
            $this->isFavorited = Auth::user()->favorites->contains($this->painting->id);
        } else {
            $this->isFavorited = false;
        }
        $this->hasLikes = $this->painting->favorited_by_count > 0;
        $this->favoriteCount = $this->painting->favorited_by_count ?? 0;
    }
}
