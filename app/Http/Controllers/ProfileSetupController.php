<?php

namespace App\Http\Controllers;

use App\Enums\RelationshipIntent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProfileSetupController extends Controller
{
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
                Storage::disk('public')->delete($user->photo_path);
            }

            $photoPath = $this->handlePhotoUpload($request->file('photo'));
            $validated['photo_path'] = $photoPath;
        }

        unset($validated['photo']);

        $user->update($validated);

        return redirect()->route('dashboard')->with('success', 'Profile completed successfully!');
    }

    private function handlePhotoUpload($file): string
    {
        $randomString = Str::random(32);
        $filename = 'profile_'.$randomString.'_'.time().'.'.$file->getClientOriginalExtension();
        $path = 'profile-photos/'.$filename;

        $manager = new ImageManager(new Driver);

        $image = $manager->read($file->getPathname());

        $image->scaleDown(width: 800, height: 800);

        $optimizedImage = $image->toJpeg(85);

        Storage::disk('public')->put($path, $optimizedImage);

        return $path;
    }
}
