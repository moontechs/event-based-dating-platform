<?php

namespace App\Livewire;

use App\Enums\ConnectionStatus;
use App\Models\ConnectionRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class MatchesList extends Component
{
    #[Computed]
    public function matches()
    {
        return ConnectionRequest::with(['sender', 'receiver'])
            ->where(function ($query) {
                $query->where('sender_id', Auth::user()->id)
                    ->orWhere('receiver_id', Auth::user()->id);
            })
            ->where('status', ConnectionStatus::Accepted)
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    #[On('matchDisconnected')]
    public function refreshAfterDisconnect(): void
    {
        unset($this->matches);
    }

    public function render()
    {
        return view('livewire.matches-list');
    }
}
