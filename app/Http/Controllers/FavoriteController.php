<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Painting;

class FavoriteController extends Controller
{
    public function toggle(Painting $painting)
    {
        $user = auth()->user();

        if ($user->favorites()->where('painting_id', $painting->id)->exists()) {
            $user->favorites()->detach($painting->id);
        } else {
            $user->favorites()->attach($painting->id);
        }

        return back();
    }
}
