<?php

namespace App\Http\Controllers;

use App\Enums\RelationshipIntent;
use App\Models\User;
use App\Services\ProfileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct(
        private ProfileService $profileService
    ) {}

    public function show(?User $user = null): View
    {
        /** @var User $currentUser */
        $currentUser = auth()->user();
        $profileUser = $user ?? $currentUser;

        $hasFullAccess = $this->profileService->hasFullProfileAccess($currentUser, $profileUser);

        return view('profile.show', [
            'user' => $profileUser,
            'currentUser' => $currentUser,
            'hasFullAccess' => $hasFullAccess,
            'isOwnProfile' => $currentUser->id === $profileUser->id,
        ]);
    }

    public function edit(): View
    {
        $user = auth()->user();

        return view('profile.edit', [
            'user' => $user,
            'relationshipIntents' => RelationshipIntent::cases(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $validated = $request->validate([
            'photo' => ['nullable', 'image', 'max:10240'],
            'full_name' => ['required', 'string', 'max:255'],
            'whatsapp_number' => ['required', 'string', 'max:20'],
            'relationship_intent' => ['required', Rule::enum(RelationshipIntent::class)],
        ]);

        if ($request->hasFile('photo')) {
            if ($user->photo_path) {
                $this->profileService->deletePhoto($user);
            }

            $photoPath = $this->profileService->handlePhotoUpload($request->file('photo'));
            $validated['photo_path'] = $photoPath;
        }

        unset($validated['photo']);

        $user->update($validated);

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }
}
