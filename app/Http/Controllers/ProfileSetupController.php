<?php

namespace App\Http\Controllers;

use App\Enums\RelationshipIntent;
use App\Services\ProfileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileSetupController extends Controller
{
    public function __construct(
        private ProfileService $profileService
    ) {}

    public function show(): View
    {
        $user = auth()->user();

        return view('profile.setup', [
            'user' => $user,
            'relationshipIntents' => RelationshipIntent::cases(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'photo' => ['required', 'image', 'max:10240'], // 10MB limit
            'full_name' => ['required', 'string', 'max:255'],
            'whatsapp_number' => ['required', 'string', 'max:20'],
            'relationship_intent' => ['required', Rule::enum(RelationshipIntent::class)],
            'terms_accepted' => ['required', 'accepted'],
        ]);

        $user = auth()->user();

        if ($request->hasFile('photo')) {
            if ($user->photo_path) {
                $this->profileService->deletePhoto($user);
            }

            $photoPath = $this->profileService->handlePhotoUpload($request->file('photo'));
            $validated['photo_path'] = $photoPath;
        }

        unset($validated['photo']);

        $user->update($validated);

        return redirect()->route('dashboard')->with('success', 'Profile completed successfully!');
    }
}
