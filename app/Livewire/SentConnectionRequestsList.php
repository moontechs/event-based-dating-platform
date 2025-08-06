<?php

namespace App\Livewire;

use App\Enums\ConnectionStatus;
use App\Models\ConnectionRequest;
use App\Services\ConnectionService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;

class SentConnectionRequestsList extends Component
{
    #[Computed]
    public function sentRequests()
    {
        return ConnectionRequest::with(['receiver'])
            ->where('sender_id', Auth::user()->id)
            ->where('status', ConnectionStatus::Pending)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    #[Computed]
    public function connectionData(ConnectionService $connectionService)
    {
        return $connectionService->getConnectionRequestData(Auth::user());
    }

    public function render()
    {
        return view('livewire.sent-connection-requests-list');
    }
}
