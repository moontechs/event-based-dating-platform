<?php

namespace App\Livewire;

use App\Models\User;
use App\Services\ConnectionService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class DisconnectMatchButton extends Component
{
    public User $connectionUser;

    public function mount(User $connectionUser): void
    {
        $this->connectionUser = $connectionUser;
    }

    public function disconnect(ConnectionService $connectionService): void
    {
        $result = $connectionService->disconnectMatch(Auth::user(), $this->connectionUser);

        if ($result['success']) {
            Toaster::success($result['message']);
            $this->dispatch('matchDisconnected');
        } else {
            Toaster::error($result['message']);
        }
    }

    public function render()
    {
        return view('livewire.disconnect-match-button');
    }
}
