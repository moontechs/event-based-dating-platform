<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class ProfileImageUpload extends Component
{
    use WithFileUploads;

    public $newImagesBuffer = [];

    public $newImages = [];

    public $tempImages = [];

    public $deletedImages = [];

    public $mainImageId;

    public $user;

    protected $listeners = ['profile-updated' => 'refreshUser'];

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
    }

    public function removeNewImage($index)
    {
        unset($this->newImages[$index]);
        unset($this->tempImages[$index]);

        $this->newImages = array_values($this->newImages);
        $this->tempImages = array_values($this->tempImages);
    }

    public function removeExistingImage($imageId)
    {
        $this->deletedImages[] = $imageId;

        // If this was the main image, clear the main image selection
        if ($this->mainImageId == $imageId) {
            $this->mainImageId = null;
        }
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
