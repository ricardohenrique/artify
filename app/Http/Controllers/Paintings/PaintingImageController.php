<?php

namespace App\Http\Controllers\Paintings;

use App\Http\Controllers\Controller;
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
        $disk = config('filesystems.default');
        if (\Storage::disk($disk)->exists($image->path)) {
            \Storage::disk($disk)->delete($image->path);
        }

        // Delete from DB
        $image->delete();

        return back()->with('status', 'Image removed.');
    }
}
