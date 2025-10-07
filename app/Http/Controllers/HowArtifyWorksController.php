<?php

namespace App\Http\Controllers;

class HowArtifyWorksController extends Controller
{
    public function index()
    {
        return response()->view('how-artify-works', [], 200);
    }
}
