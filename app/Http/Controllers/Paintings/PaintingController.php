<?php

namespace App\Http\Controllers\Paintings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Painting;
use App\Models\User;

class PaintingController extends Controller
{
    public function home()
    {
        $data["paintings"] = Painting::all();
        return response()->view('home', $data, 200);
    }

    public function aboutUs()
    {
        return response()->view('about-us', [], 200);
    }

    public function index()
    {
        return Painting::all();
    }

    public function member(string $id)
    {
        $user = User::findOrFail($id);
        return response()->view('member', ['user' => $user], 200);
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
