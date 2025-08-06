<?php

namespace App\Livewire;

use App\Models\User;
use App\Services\ConnectionService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class AcceptConnectionRequestButtons extends Component
{
    public User $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function accept(ConnectionService $connectionService)
    {
        $result = $connectionService->acceptConnectionRequest(Auth::user(), $this->user);

        if ($result['success']) {
            $this->dispatch('connectionRequestAccepted');
            Toaster::success($result['message']);
        } else {
            Toaster::error($result['message']);
        }
    }

    public function reject(ConnectionService $connectionService)
    {
        $result = $connectionService->rejectConnectionRequest(Auth::user(), $this->user);

        if ($result['success']) {
            $this->dispatch('connectionRequestRejected');
            Toaster::success($result['message']);
        } else {
            Toaster::error($result['message']);
        }
    }

    public function render()
    {
        return view('livewire.accept-connection-request-buttons');
    }
}
