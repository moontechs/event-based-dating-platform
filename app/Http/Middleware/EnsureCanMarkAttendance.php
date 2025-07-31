<?php

namespace App\Http\Middleware;

use App\Models\Event;
use App\Services\EventService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCanMarkAttendance
{
    public function __construct(
        private EventService $eventService
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $event = $request->route('event');

        if (! $event instanceof Event) {
            abort(404, 'Event not found');
        }

        // Check if event is published
        if (! $event->is_published) {
            abort(404, 'Event not found');
        }

        // Check if user can mark attendance for this event
        if (! $this->eventService->canUserMarkAttendance($event)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot modify attendance for this event. Events can only be modified up to 2 days after they finish.',
                ], 403);
            }

            return redirect()->back()->with('error', 'You cannot modify attendance for this event. Events can only be modified up to 2 days after they finish.');
        }

        return $next($request);
    }
}
