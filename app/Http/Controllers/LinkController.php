<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;

class LinkController extends Controller
{
    public function redirect($slug)
    {
        $link = Link::where('slug', $slug)->firstOrFail();

        $link->increment('clicks');

        return redirect()->away($link->target_url);
    }
}
