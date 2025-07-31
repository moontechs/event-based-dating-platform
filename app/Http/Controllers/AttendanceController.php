<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Services\EventService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function __construct(
        private EventService $eventService
    ) {}

    public function toggle(Event $event, Request $request): JsonResponse|RedirectResponse
    {
        if (! $event->is_published) {
            abort(404);
        }

        $result = $this->eventService->toggleAttendance($event);

        if ($request->expectsJson()) {
            return response()->json($result);
        }

        if ($result['success']) {
            return redirect()->back()->with('success', $result['message']);
        } else {
            return redirect()->back()->with('error', $result['message']);
        }
    }
}
