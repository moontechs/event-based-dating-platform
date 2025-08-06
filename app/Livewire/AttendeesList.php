<?php

namespace App\Livewire;

use App\Models\Event;
use App\Services\ConnectionService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class AttendeesList extends Component
{
    public Event $event;

    public $attendances;

    public $connectionData;

    public function mount(Event $event, ConnectionService $connectionService)
    {
        $this->event = $event;

        $this->updateReactiveProperties($connectionService);
    }

    #[On('attendanceToggled')]
    public function refreshAttendees(ConnectionService $connectionService)
    {
        $this->event = $this->event->fresh();

        $this->updateReactiveProperties($connectionService);
    }

    #[On('connectionRequestSent')]
    public function onConnectionRequestSent($userId)
    {
        if (! in_array($userId, $this->connectionData['pending'])) {
            $this->connectionData['pending'][] = $userId;
        }
    }

    #[On('connectionRequestCancelled')]
    public function onConnectionRequestCancelled($userId)
    {
        $this->connectionData['pending'] = array_filter(
            $this->connectionData['pending'],
            fn ($id) => $id !== $userId
        );

        $this->connectionData['pending'] = array_values($this->connectionData['pending']);
    }

    public function render()
    {
        return view('livewire.attendees-list');
    }

    private function updateReactiveProperties(ConnectionService $connectionService): void
    {
        $this->attendances = $this->event->attendances()->with(['user.mainProfileImage'])->get();

        $this->connectionData = $connectionService->getConnectionRequestData(Auth::user());
    }
}
