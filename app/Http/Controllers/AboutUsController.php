<?php

namespace App\Http\Controllers;

class AboutUsController extends Controller
{
    public function index()
    {
        return response()->view('about-us', [], 200);
    }
}
