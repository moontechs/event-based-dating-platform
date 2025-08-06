<?php

namespace App\Livewire;

use App\Services\ProfileService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toaster;

class ProfileImageUpload extends Component
{
    use WithFileUploads;

    public $newImagesBuffer = [];

    public $newImages = [];

    public $tempImages = [];

    public $deletedImages = [];

    public $mainImageId;

    /**
     * @var \App\Models\User
     */
    public $user;

    private ProfileService $profileService;

    protected $listeners = ['profile-updated' => 'handleProfileUpdated'];

    public function boot(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    protected $rules = [
        'newImages.*' => 'image|max:10240', // 10MB max
        'newImagesBuffer.*' => 'image|max:10240',
    ];

    public function mount($user)
    {
        $this->user = $user;
        $this->user->load('profileImages');
        $this->mainImageId = $user->mainProfileImage?->id;
    }

    public function validateImages(): bool
    {
        $finalImageCount = $this->getFinalImageCount();
        $minImages = config('profile.images.count.min', 2);
        $maxImages = config('profile.images.count.max', 4);

        if ($finalImageCount < $minImages) {
            $this->addError('images', "You must have at least {$minImages} profile images.");

            return false;
        }

        if ($finalImageCount > $maxImages) {
            $this->addError('images', "You can have at most {$maxImages} profile images.");

            return false;
        }

        return true;
    }

    public function getFinalImageCount(): int
    {
        $existingCount = $this->user->profileImages->whereNotIn('id', $this->deletedImages)->count();
        $newCount = count($this->newImages);

        return $existingCount + $newCount;
    }

    public function saveImages()
    {
        if (! $this->validateImages()) {
            return false;
        }

        if (! empty($this->newImages) || ! empty($this->deletedImages) || $this->mainImageId !== null) {
            try {
                $this->profileService->saveProfileImages(
                    $this->user,
                    $this->newImages,
                    $this->deletedImages,
                    $this->mainImageId
                );

                $this->newImages = [];
                $this->tempImages = [];
                $this->deletedImages = [];
            } catch (\Exception $e) {
                Log::error('Failed to save profile images', [
                    'user_id' => $this->user->id,
                    'new_images_count' => count($this->newImages),
                    'deleted_images' => $this->deletedImages,
                    'main_image_id' => $this->mainImageId,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);

                return false;
            }
        }

        $this->refreshUser();

        return true;
    }

    public function handleProfileUpdated()
    {
        if (! $this->validateImages()) {
            Toaster::error('Failed to update profile images. Please check the errors and try again.');

            return;
        }

        if ($this->saveImages()) {
            Toaster::success('Profile updated successfully!');
        } else {
            Toaster::error('Failed to update profile images. Please check the errors and try again.');
        }
    }

    public function refreshUser()
    {
        $this->user->refresh();
        $this->user->load('profileImages');
        $this->mainImageId = $this->user->mainProfileImage?->id;
    }

    public function updatedNewImagesBuffer()
    {
        $this->validate([
            'newImagesBuffer.*' => 'image|max:10240',
        ]);

        foreach ($this->newImagesBuffer as $image) {
            $this->newImages[] = $image;
        }

        foreach ($this->newImages as $key => $image) {
            if (! isset($this->tempImages[$key])) {
                $this->tempImages[$key] = [
                    'file' => $image,
                    'preview' => $image->temporaryUrl(),
                ];
            }
        }

        $this->newImagesBuffer = [];

        // Clear previous validation errors when user adds images
        $this->clearValidation('images');
    }

    public function removeNewImage($index)
    {
        unset($this->newImages[$index]);
        unset($this->tempImages[$index]);

        $this->newImages = array_values($this->newImages);
        $this->tempImages = array_values($this->tempImages);

        // Clear previous validation errors when user removes images
        $this->clearValidation('images');
    }

    public function removeExistingImage($imageId)
    {
        $this->deletedImages[] = $imageId;

        // If this was the main image, clear the main image selection
        if ($this->mainImageId == $imageId) {
            $this->mainImageId = null;
        }

        // Clear previous validation errors when user makes changes
        $this->clearValidation('images');
    }

    public function setMainImage($imageId)
    {
        $this->mainImageId = $imageId;
    }

    public function getTotalImagesProperty()
    {
        $existingCount = $this->user->profileImages->whereNotIn('id', $this->deletedImages)->count();
        $newCount = count($this->newImages);

        return $existingCount + $newCount;
    }

    public function getCanAddMoreProperty()
    {
        return $this->totalImages < config('profile.images.count.max');
    }

    public function render()
    {
        return view('livewire.profile-image-upload');
    }
}
