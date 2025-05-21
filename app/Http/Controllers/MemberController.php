<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
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

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
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
