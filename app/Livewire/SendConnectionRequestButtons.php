<?php

namespace App\Livewire;

use App\Enums\ConnectionStatus;
use App\Models\ConnectionRequest;
use App\Models\User;
use App\Services\ConnectionService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class SendConnectionRequestButtons extends Component
{
    public User $user;

    #[Reactive]
    public ?array $connectionData = null;

    public function mount(User $user, ?array $connectionData = null)
    {
        $this->user = $user;
        $this->connectionData = $connectionData;
    }

    #[Computed]
    public function isCurrentUser(): bool
    {
        return $this->user->id === auth()->id();
    }

    #[Computed]
    public function connectionStatus()
    {
        if (! auth()->check()) {
            return null;
        }

        if ($this->connectionData && in_array($this->user->id, $this->connectionData['accepted'])) {
            return ConnectionStatus::Accepted;
        }

        return ConnectionRequest::getConnectionStatus(auth()->user(), $this->user);
    }

    #[Computed]
    public function hasPendingRequest()
    {
        if (! auth()->check()) {
            return false;
        }

        if ($this->connectionData) {
            return in_array($this->user->id, $this->connectionData['pending']);
        }

        return ConnectionRequest::hasPendingRequest(auth()->user(), $this->user);
    }

    #[Computed]
    public function isEligible()
    {
        if (! auth()->check()) {
            return false;
        }

        return ConnectionRequest::areUsersEligible(auth()->user(), $this->user);
    }

    #[Computed]
    public function showConnectButton()
    {
        return ! $this->isCurrentUser &&
               $this->connectionStatus !== ConnectionStatus::Accepted &&
               ! $this->hasPendingRequest &&
               $this->isEligible;
    }

    #[Computed]
    public function showCancelButton()
    {
        return ! $this->isCurrentUser &&
               $this->hasPendingRequest;
    }

    public function sendRequest(ConnectionService $connectionService)
    {
        $result = $connectionService->sendConnectionRequest(Auth::user(), $this->user);

        if ($result['success']) {
            $this->dispatch('connectionRequestSent', userId: $this->user->id);
            Toaster::success($result['message']);
        } else {
            Toaster::error($result['message']);
        }
    }

    public function cancelRequest(ConnectionService $connectionService)
    {
        $result = $connectionService->cancelConnectionRequest(Auth::user(), $this->user);

        if ($result['success']) {
            $this->dispatch('connectionRequestCancelled', userId: $this->user->id);
            Toaster::success($result['message']);
        } else {
            Toaster::error($result['message']);
        }
    }

    public function render()
    {
        return view('livewire.send-connection-request-buttons');
    }
}
