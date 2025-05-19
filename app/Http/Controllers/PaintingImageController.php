<?php

namespace App\Http\Controllers;

use App\Models\PaintingImage;
use Illuminate\Http\Request;

class PaintingImageController extends Controller
{
    public function destroy(PaintingImage $image)
    {
        // Ensure user owns the painting
        if ($image->painting->user_id !== auth()->id()) {
            abort(403);
        }

        // Delete image from storage
        \Storage::disk('public')->delete($image->path);

        // Delete from DB
        $image->delete();

        return back()->with('status', 'Image removed.');
    }
}
