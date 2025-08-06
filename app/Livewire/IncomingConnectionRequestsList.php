<?php

namespace App\Livewire;

use App\Enums\ConnectionStatus;
use App\Models\ConnectionRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class IncomingConnectionRequestsList extends Component
{
    #[Computed]
    public function incomingRequests()
    {
        return ConnectionRequest::with(['sender'])
            ->where('receiver_id', Auth::user()->id)
            ->where('status', ConnectionStatus::Pending)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    #[On('connectionRequestAccepted')]
    #[On('connectionRequestRejected')]
    public function refreshAfterRequestAction()
    {
        unset($this->incomingRequests);
    }

    public function render()
    {
        return view('livewire.incoming-connection-requests-list');
    }
}
