<?php

namespace App\Services;

use App\Models\Event;
use App\Models\EventCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class EventService
{
    public function getFilteredEvents(array $filters = [], int $perPage = 12): LengthAwarePaginator
    {
        $query = Event::query()
            ->with(['category', 'attendances.user', 'timeZone'])
            ->published()
            ->orderBy('date_time', 'desc');

        // Apply filters
        if (! empty($filters['category'])) {
            $query->byCategory($filters['category']);
        }

        if (! empty($filters['city']) || ! empty($filters['country'])) {
            $query->byLocation($filters['city'] ?? null, $filters['country'] ?? null);
        }

        if (! empty($filters['start_date']) || ! empty($filters['end_date'])) {
            $startDate = ! empty($filters['start_date']) ? Carbon::parse($filters['start_date']) : null;
            $endDate = ! empty($filters['end_date']) ? Carbon::parse($filters['end_date']) : null;
            $query->byDateRange($startDate, $endDate);
        }

        if (! empty($filters['search'])) {
            $query->search($filters['search']);
        }

        return $query->paginate($perPage);
    }

    public function getEventWithAttendees(int $eventId): ?Event
    {
        return Event::with([
            'category',
            'timeZone',
            'attendances.user' => function ($query) {
                $query->select('id', 'name', 'full_name', 'relationship_intent', 'slug')
                    ->active();
            },
        ])->find($eventId);
    }

    public function canUserMarkAttendance(Event $event, ?User $user = null): bool
    {
        if (! $user) {
            $user = auth()->user();
        }

        if (! $user || $user->isInactive()) {
            return false;
        }

        return $event->canMarkAttendance();
    }

    public function canUserCancelAttendance(Event $event, ?User $user = null): bool
    {
        if (! $user) {
            $user = auth()->user();
        }

        if (! $user || $user->isInactive()) {
            return false;
        }

        // Same rule as marking attendance - can only cancel within 2 days after event
        return $event->canMarkAttendance();
    }

    public function toggleAttendance(Event $event, ?User $user = null): array
    {
        if (! $user) {
            $user = auth()->user();
        }

        $attendance = $event->attendances()->where('user_id', $user->id)->first();

        if ($attendance) {
            // User is attending, check if they can cancel
            if (! $this->canUserCancelAttendance($event, $user)) {
                return [
                    'success' => false,
                    'message' => 'You cannot cancel attendance for this event. Events can only be modified up to 2 days after they finish',
                    'attending' => true,
                ];
            }

            // Remove attendance
            $attendance->delete();

            return [
                'success' => true,
                'message' => 'Attendance cancelled successfully',
                'attending' => false,
                'attendees_count' => $event->attendances()->count(),
            ];
        } else {
            // User is not attending, check if they can mark attendance
            if (! $this->canUserMarkAttendance($event, $user)) {
                return [
                    'success' => false,
                    'message' => 'You cannot mark attendance for this event. Events can only be modified up to 2 days after they finish',
                    'attending' => false,
                ];
            }

            // Add attendance
            $event->attendances()->create(['user_id' => $user->id]);

            return [
                'success' => true,
                'message' => 'Attendance marked successfully',
                'attending' => true,
                'attendees_count' => $event->attendances()->count(),
            ];
        }
    }

    public function getEventCategories(): \Illuminate\Database\Eloquent\Collection
    {
        return EventCategory::where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    public function getUpcomingEvents(int $limit = 6): \Illuminate\Database\Eloquent\Collection
    {
        return Event::with(['category'])
            ->published()
            ->future()
            ->orderBy('date_time', 'asc')
            ->limit($limit)
            ->get();
    }

    public function getEventStatistics(Event $event): array
    {
        return [
            'total_attendees' => $event->attendances()->count(),
            'can_mark_attendance' => $event->canMarkAttendance(),
            'can_cancel_attendance' => $event->canMarkAttendance(), // Same rule applies
            'user_attending' => auth()->check() ? $event->isUserAttending() : false,
            'is_past_event' => $event->date_time < now(),
            'is_future_event' => $event->date_time > now(),
        ];
    }

    public function searchEvents(string $query, int $perPage = 12): LengthAwarePaginator
    {
        return Event::with(['category', 'timeZone'])
            ->published()
            ->search($query)
            ->orderBy('date_time', 'asc')
            ->paginate($perPage);
    }

    public function getUsersAttendedSameEventsAsUser(User $user): \Illuminate\Database\Eloquent\Collection|Collection
    {
        $visitedEventIds = $user->eventAttendances()->get()->pluck('event_id')->toArray();

        if (empty($visitedEventIds)) {
            return collect();
        }

        return User::whereHas('eventAttendances.event', function ($query) use ($visitedEventIds) {
            $query->whereIn('id', $visitedEventIds)
                ->where('is_published', true);
        })->get();
    }

    public function getUserAttendedEvents(?User $user = null): \Illuminate\Database\Eloquent\Collection
    {
        if (! $user) {
            $user = auth()->user();
        }

        if (! $user) {
            return collect();
        }

        return Event::with(['category'])
            ->published()
            ->whereHas('attendances', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->orderBy('date_time', 'desc')
            ->get();
    }

    public function getUniqueCities(): Collection
    {
        return Event::published()
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->distinct()
            ->orderBy('city')
            ->pluck('city');
    }

    public function getUniqueCountries(): Collection
    {
        return Event::published()
            ->whereNotNull('country')
            ->where('country', '!=', '')
            ->distinct()
            ->orderBy('country')
            ->pluck('country');
    }

    public function getUniqueCityCountryPairs(): Collection
    {
        return Event::published()
            ->whereNotNull('city')
            ->whereNotNull('country')
            ->where('city', '!=', '')
            ->where('country', '!=', '')
            ->select('city', 'country')
            ->distinct()
            ->orderBy('country')
            ->orderBy('city')
            ->get()
            ->map(function ($event) {
                return [
                    'city' => $event->city,
                    'country' => $event->country,
                    'display' => $event->city.', '.$event->country,
                ];
            });
    }
}
