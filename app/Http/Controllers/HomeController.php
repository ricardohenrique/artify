<?php

namespace App\Http\Controllers;

use App\Models\Painting;

class HomeController extends Controller
{
    public function index()
    {
        $data["paintings"] = Painting::all();
        return response()->view('home', $data, 200);
    }
}
