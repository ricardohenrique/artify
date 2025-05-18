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
        $isDraft = $request->input('action') === 'draft';

        $rules = [
            'title' => $isDraft ? 'nullable|string|max:255' : 'required|string|max:255',
            'description' => $isDraft ? 'nullable|string' : 'required|string',
            'price' => $isDraft ? 'nullable|numeric|min:0' : 'required|numeric|min:0',
            'category' => $isDraft ? 'nullable|string' : 'required|string',
            'image' => $isDraft ? 'nullable|image|max:2048' : 'required|image|max:2048',
        ];

        $validated = $request->validate($rules);

        $path = $request->hasFile('image') ? $request->file('image')->store('paintings', 'public') : null;

        Painting::create([
            'title' => $validated['title'] ?? null,
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'] ?? null,
            'category' => $validated['category'] ?? null,
            'image' => $path,
            'user_id' => auth()->id(),
            'is_draft' => $isDraft,
        ]);

        return redirect()->route('dashboard')->with('status', $isDraft ? 'Draft saved.' : 'Artwork published!');
    }

    public function dashboard()
    {
        $user = auth()->user();
        return view('dashboard', [
            'paintings' => $user->paintings()->where('is_draft', false)->latest()->get(),
            'drafts' => $user->paintings()->where('is_draft', true)->latest()->get(),
        ]);
    }

    public function destroy(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $painting = Painting::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return response()->view('about-us', [], 200);
    }
}
