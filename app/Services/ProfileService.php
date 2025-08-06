<?php

namespace App\Services;

use App\Models\ConnectionRequest;
use App\Models\ProfileImage;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProfileService
{
    public function saveProfileImages(User $user, array $newImages, array $deletedImages, ?int $mainImageId): void
    {
        $imagesToDelete = [];

        DB::transaction(function () use ($user, $newImages, $deletedImages, $mainImageId, &$imagesToDelete) {
            foreach ($deletedImages as $imageId) {
                $image = ProfileImage::find($imageId);
                if ($image && $image->user_id === $user->id) {
                    $imagesToDelete[] = $image->image_path;
                    $image->delete();
                }
            }

            foreach ($newImages as $file) {
                $path = $this->handlePhotoUpload($file);
                ProfileImage::create([
                    'user_id' => $user->id,
                    'image_path' => $path,
                    'is_main' => false,
                ]);
            }

            if ($mainImageId) {
                if ($mainImageId === $user->mainProfileImage?->id) {
                    return;
                }

                $user->profileImages()->update(['is_main' => false]);

                $mainImage = $user->profileImages()->find($mainImageId);
                $mainImage?->update(['is_main' => true]);
            } elseif ($user->profileImages()->count() > 0 && ! $user->profileImages()->where('is_main', true)->exists()) {
                // if no main image is set, and we have images, set the first one as main
                $user->profileImages()->first()->update(['is_main' => true]);
            }
        });

        foreach ($imagesToDelete as $imagePath) {
            Storage::disk('public')->delete($imagePath);
        }
    }

    public function hasFullProfileAccess(User $viewer, User $profileOwner): bool
    {
        if ($viewer->id === $profileOwner->id) {
            return true;
        }

        return ConnectionRequest::usersConnected($viewer, $profileOwner);
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
