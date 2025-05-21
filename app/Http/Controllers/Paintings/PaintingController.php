<?php

namespace App\Http\Controllers\Paintings;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Painting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class PaintingController extends Controller
{


    public function index()
    {
        return Painting::all();
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        $paintings = Painting::with(['images', 'category'])
            ->withCount('favoritedBy')
            ->where('title', 'like', '%' . $query . '%')
            ->orWhere('description', 'like', '%' . $query . '%')
            ->latest()
            ->paginate(12);
    
        return view('painting.search', [
            'paintings' => $paintings,
            'query' => $query,
        ]);
    }

    public function new()
    {
        $user = Auth::user();
        $categories = Category::orderBy('name')->get();

        return view('painting.form', [
            'user' => $user,
            'painting' => new Painting(),
            'categories' => $categories,
            'route' => route('item.store'),
            'method' => 'POST',
            'isEdit' => false,
        ]);
    }

    public function store(Request $request)
    {
        $isDraft = $request->input('action') === 'draft';

        $rules = [
            'title'         => $isDraft ? 'nullable|string|max:255' : 'required|string|max:255',
            'description'   => $isDraft ? 'nullable|string' : 'required|string',
            'price'         => $isDraft ? 'nullable|numeric|min:0' : 'required|numeric|min:0',
            'category_id'   => $isDraft ? 'nullable|exists:categories,id' : 'required|exists:categories,id',
            'images'        => 'nullable|array|max:5',
            'images.*'      => 'image|mimes:jpg,jpeg,png|max:2048',
        ];

        $validated = $request->validate($rules);

        $painting = Painting::create([
            'title'         => $validated['title'] ?? null,
            'slug'          => isset($validated['title']) ? Str::slug($validated['title'] . '-' . uniqid()) : null,
            'description'   => $validated['description'] ?? null,
            'price'         => $validated['price'] ?? null,
            'category_id'   => $validated['category_id'] ?? null,
            'user_id'       => auth()->id(),
            'is_draft'      => $isDraft,
        ]);

        if ($request->hasFile('images')) {
            if ( ($painting->images()->count() + count($request->file('images'))) > 5) {
                return back()->withErrors(['images' => 'You can upload a maximum of 5 images in total.'])->withInput();
            }
            foreach ($request->file('images') as $image) {
                $path = $image->store('paintings', 'public');
                $painting->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('dashboard')->with('status', $isDraft ? 'Draft saved.' : 'Artwork published!');
    }

    public function update(Request $request, Painting $painting)
    {
        if ($painting->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $isDraft = $request->input('action') === 'draft';

        $rules = [
            'title'         => $isDraft ? 'nullable|string|max:255' : 'required|string|max:255',
            'description'   => $isDraft ? 'nullable|string' : 'required|string',
            'price'         => $isDraft ? 'nullable|numeric|min:0' : 'required|numeric|min:0',
            'category_id'   => $isDraft ? 'nullable|exists:categories,id' : 'required|exists:categories,id',
            'images'        => 'nullable|array|max:5',
            'images.*'      => 'image|mimes:jpg,jpeg,png|max:2048',
        ];

        $validated = $request->validate($rules);

        $currentImageCount = $painting->images()->count();
        $newImageCount = $request->hasFile('images') ? count($request->file('images')) : 0;
        if (($currentImageCount + $newImageCount) > 5) {
            return back()->withErrors(['images' => 'You can upload a maximum of 5 images in total.'])->withInput();
        }

        // If a new image is uploaded, store it
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $path = $imageFile->store('paintings', 'public');
                $painting->images()->create(['path' => $path]);
            }
        }

        // Update other fields
        $painting->title        = $validated['title'] ?? $painting->title;
        $painting->slug         = isset($validated['title']) ? Str::slug($validated['title'] . '-' . uniqid()) : null;
        $painting->description  = $validated['description'] ?? $painting->description;
        $painting->price        = $validated['price'] ?? $painting->price;
        $painting->category_id  = $validated['category_id'] ?? $painting->category_id;
        $painting->is_draft     = $isDraft;

        $painting->save();

        return redirect()->route('dashboard')->with('status', $isDraft ? 'Draft updated.' : 'Painting updated!');
    }

    public function edit(string $id)
    {
        $painting = Painting::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
        $categories = Category::orderBy('name')->get();

        return view('painting.form', [
            'painting' => $painting,
            'categories' => $categories,
            'route' => route('item.update', $painting),
            'method' => 'PUT',
            'isEdit' => true,
        ]);
    }

    public function show(string $categorySlug, string $paintingSlug)
    {
        $painting = Painting::where('slug', $paintingSlug)
            ->with(['user', 'images', 'category'])
            ->withCount('favoritedBy')
            ->firstOrFail();

        return view('painting.show', [
            'painting' => $painting,
        ]);
    }
}
