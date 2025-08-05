<?php

namespace App\Livewire;

use Livewire\Component;

class ProfileImages extends Component
{
    public $user;

    public $hasFullAccess = false;

    public $isOwnProfile = false;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.profile-images');
    }
}
