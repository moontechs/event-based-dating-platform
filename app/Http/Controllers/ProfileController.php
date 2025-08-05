<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ProfileService;
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
        $profileUser->load('profileImages');

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
        return view('profile.edit');
    }
}
