<?php

namespace App\Http\Controllers\Paintings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Painting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


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

    public function new()
    {
        $user = Auth::user();
        return response()->view('painting.new', ['user' => $user], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'image' => 'required|image|max:2048',
        ]);
    
        $path = $request->file('image')->store('paintings', 'public');
    
        Painting::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'category' => $validated['category'],
            'image' => $path,
            'user_id' => auth()->id(), // If tied to user
        ]);
    
        return redirect()->route('dashboard')->with('status', 'Painting listed successfully!');
    }

    public function dashboard()
    {
        $user = auth()->user()->load('paintings'); // Eager-load paintings
        return response()->view('dashboard', ['paintings' => $user->paintings], 200);
    }

    public function destroy(string $id)
    {
        //
    }
}
