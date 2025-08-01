<?php

namespace App\Services;

use App\Models\ConnectionRequest;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProfileService
{
    public function handlePhotoUpload($file): string
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

    public function deletePhoto(User $user): void
    {
        if ($user->photo_path) {
            Storage::disk('public')->delete($user->photo_path);
        }
    }

    public function hasFullProfileAccess(User $viewer, User $profileOwner): bool
    {
        if ($viewer->id === $profileOwner->id) {
            return true;
        }

        return ConnectionRequest::usersConnected($viewer, $profileOwner);
    }
}
