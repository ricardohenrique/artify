<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class MemberController extends Controller
{
    public function member(string $id)
    {
        $user = User::withCount(['followers', 'following'])->findOrFail($id);
        return response()->view('member', ['user' => $user], 200);
    }

    public function dashboard()
    {
        $user = auth()->user();
        return view('dashboard', [
            'paintings' => $user->paintings()->where('is_draft', false)->latest()->get(),
            'drafts' => $user->paintings()->where('is_draft', true)->latest()->get(),
        ]);
    }

    public function edit(string $id)
    {
        $user = User::withCount(['followers', 'following'])->findOrFail($id);
        return view('member.edit', compact('user'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        if ($user->id !== auth()->id()) {
            abort(403);
        }
    
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,
            'bio' => 'nullable|string|max:1000',
            'location' => 'nullable|string|max:255',
            'website_url' => 'nullable|url|max:255',
            // 'profile_image' => 'nullable|image|max:2048',
        ]);
    
        // Optional image handling
        // if ($request->hasFile('profile_image')) {
        //     $validated['profile_image'] = $request->file('profile_image')->store('avatars', 'public');
        // }
    
        $user->update($validated);
    
        return redirect()->route('member.edit', $user->id)->with('status', 'Profile updated!');
    }

    public function favorites(string $id)
    {
        $user = User::findOrFail($id);

        $favorites = $user->favorites()
            ->with(['images', 'category'])
            ->withCount('favoritedBy')
            ->latest()
            ->paginate(12);

        return view('member.favorites', [
            'user' => $user,
            'favorites' => $favorites,
        ]);
    }
}
