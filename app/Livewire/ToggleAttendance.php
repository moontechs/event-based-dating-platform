<?php

namespace App\Livewire;

use App\Models\Event;
use App\Services\EventService;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class ToggleAttendance extends Component
{
    /**
     * @var Event
     */
    public $event;

    public bool $userAttending = false;

    public bool $canMarkAttendance = false;

    public array $statistics;

    public function mount(Event $event, array $statistics = [])
    {
        $this->event = $event;
        $this->statistics = $statistics;
        $this->userAttending = auth()->check() && $event->isUserAttending();
        $this->canMarkAttendance = $event->canMarkAttendance();
    }

    #[Computed]
    public function isPastEvent()
    {
        return $this->statistics['is_past_event'] ?? false;
    }

    public function toggleAttendance(EventService $eventService)
    {
        $event = $this->event;

        if (! $event->is_published) {
            abort(404);
        }

        $result = $eventService->toggleAttendance($event);

        if ($result['success']) {
            $this->userAttending = $this->event->isUserAttending();
            $this->canMarkAttendance = $this->event->canMarkAttendance();

            $this->dispatch('attendanceToggled');

            Toaster::success($result['message']);
        } else {
            Toaster::error($result['message']);
        }
    }

    public function render()
    {
        return view('livewire.toggle-attendance');
    }
}
