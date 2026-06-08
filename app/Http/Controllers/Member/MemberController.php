<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class MemberController extends Controller
{
    protected UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function member(string $id)
    {
        $user = $this->userService->getUserById($id);
        if ($user->id !== auth()->id()) {
            abort(403);
        }
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

    public function profile(string $id)
    {
        $user = User::with([
            'favorites.images', // to display painting images
            'favorites.user',   // to show painting owner
            'followers',
            'following',
        ])
        ->withCount([
            'followers',
            'following',
            'favorites',
        ])
        ->findOrFail($id);

        if ($user->id !== auth()->id()) {
            return view('config.forbidden');
        }

        return view('user.profile', compact('user'));
    }


    public function settings(string $id)
    {
        $user = User::with([
            'favorites.images', // to display painting images
            'favorites.user',   // to show painting owner
            'followers',
            'following',
        ])
        ->withCount([
            'followers',
            'following',
            'favorites',
        ])
        ->findOrFail($id);

        return view('user.account-settings', compact('user'));
    }

    public function privacy(string $id)
    {
        $user = User::with([
            'favorites.images',
            'favorites.user',
            'followers',
            'following',
        ])
        ->withCount([
            'followers',
            'following',
            'favorites',
        ])
        ->findOrFail($id);

        $userTypes = UserType::where('is_public', true)->get();

        return view('user.privacy-center', compact('user', 'userTypes'));
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
            'gender'        => 'nullable|string|in:male,female,non_binary,prefer_not_to_say',
            'date_of_birth' => 'nullable|date|before:today',
        ]);

        $user->update($validated);

        return redirect()->route('member.settings', $user->id)->with('status', 'Profile updated!');
    }

    public function updatePrivacy(Request $request, string $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        if ($user->id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'is_public' => ['nullable', 'boolean'],
            // 'show_email' => ['nullable', 'boolean'],
            'user_type_id' => ['nullable', 'exists:user_types,id'],
        ]);

        $user->is_public = $request->boolean('is_public');
        $user->user_type_id = $validated['user_type_id'] ?? null;
        $user->save();

        return redirect()->route('member.privacy', $user->id)->with('status', 'Profile updated!');
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

    public function orders(string $id)
    {
        $user = User::with([
            'favorites.images',
            'favorites.user',
            'followers',
            'following',
        ])
        ->withCount([
            'followers',
            'following',
            'favorites',
        ])
        ->findOrFail($id);

        if ($user->id !== auth()->id()) {
            return view('config.forbidden');
        }

        return view('user.orders', compact('user'));
    }

    public function memberDashboard(string $id)
    {
        $user = $this->userService->getUserById($id);
        if ($user->id !== auth()->id()) {
            return view('config.forbidden');
        }

        $user = User::with([
            'favorites.images',
            'favorites.user',
            'followers',
            'following',
        ])
        ->withCount([
            'followers',
            'following',
            'favorites',
        ])
        ->findOrFail($id);

        $paintings = $user->paintings()->where('is_draft', false)->latest()->get();
        $drafts = $user->paintings()->where('is_draft', true)->latest()->get();

        return view('user.dashboard', compact('user', 'paintings', 'drafts'));
    }
}
