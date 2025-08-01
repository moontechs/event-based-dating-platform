<?php

namespace App\Http\Controllers;

use App\Enums\ConnectionStatus;
use App\Models\ConnectionRequest;
use App\Models\Event;
use App\Services\EventService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EventController extends Controller
{
    public function __construct(
        private EventService $eventService
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['category', 'city', 'country', 'start_date', 'end_date', 'search']);

        $events = $this->eventService->getFilteredEvents($filters, 12);
        $categories = $this->eventService->getEventCategories();
        $cities = $this->eventService->getUniqueCities();
        $countries = $this->eventService->getUniqueCountries();

        return view('events.index', compact('events', 'categories', 'cities', 'countries', 'filters'));
    }

    public function show(Event $event): View
    {
        $event = $this->eventService->getEventWithAttendees($event->id);

        if (! $event || ! $event->is_published) {
            abort(404);
        }

        $acceptedConnectionRequestUserIds = [];
        $pendingConnectionRequestUserIds = [];

        Auth::user()->acceptedConnectionRequests()->get()->each(function (ConnectionRequest $connection) use (&$acceptedConnectionRequestUserIds) {
            $acceptedConnectionRequestUserIds[] = $connection->receiver_id === Auth::id() ? $connection->sender_id : $connection->receiver_id;
        });

        Auth::user()->sentConnectionRequests()->get()->each(function (ConnectionRequest $connection) use (&$pendingConnectionRequestUserIds) {
            if ($connection->status !== ConnectionStatus::Pending) {
                return;
            }

            $pendingConnectionRequestUserIds[] = $connection->receiver_id;
        });

        $eligibleUserIds = $this->eventService
            ->getUsersAttendedSameEventsAsUser(auth()->user())
            ->whereNotIn('id', $acceptedConnectionRequestUserIds)
            ->pluck('id')
            ->toArray();
        $statistics = $this->eventService->getEventStatistics($event);

        return view('events.show', compact(
            'event',
            'statistics',
            'acceptedConnectionRequestUserIds',
            'pendingConnectionRequestUserIds',
            'eligibleUserIds',
        ));
    }

    public function search(Request $request): View
    {
        $query = null;
        $events = collect();

        if ($request->has('q') && $request->filled('q')) {
            $request->validate([
                'q' => 'required|string|min:2|max:255',
            ]);

            $query = $request->input('q');

            // Get additional filters for search
            $filters = $request->only(['category', 'city', 'country']);
            $filters['search'] = $query;

            $events = $this->eventService->getFilteredEvents($filters, 12);
        }

        $categories = $this->eventService->getEventCategories();
        $cities = $this->eventService->getUniqueCities();
        $countries = $this->eventService->getUniqueCountries();

        return view('events.search', compact('events', 'query', 'categories', 'cities', 'countries'));
    }
}
