<?php

namespace App\Http\Controllers;

use App\Enums\ConnectionStatus;
use App\Models\ConnectionRequest;
use App\Models\User;
use App\Services\ConnectionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConnectionController extends Controller
{
    public function __construct(
        private ConnectionService $connectionService
    ) {}

    /**
     * Accept a connection request
     */
    public function acceptRequest(Request $request, User $user): RedirectResponse
    {
        $receiver = Auth::user();

        $connectionRequest = ConnectionRequest::where('sender_id', $user->id)
            ->where('receiver_id', $receiver->id)
            ->where('status', ConnectionStatus::Pending)
            ->first();

        if (! $connectionRequest) {
            return back()->with('error', 'No pending connection request found');
        }

        if ($connectionRequest->accept()) {
            return back()->with('success', "You and {$user->name} are now connected!");
        }

        return back()->with('error', 'Unable to accept connection request');
    }

    /**
     * Reject a connection request
     */
    public function rejectRequest(Request $request, User $user): RedirectResponse
    {
        $receiver = Auth::user();

        $connectionRequest = ConnectionRequest::where('sender_id', $user->id)
            ->where('receiver_id', $receiver->id)
            ->whereIn('status', [ConnectionStatus::Pending, ConnectionStatus::Accepted])
            ->first();

        if (! $connectionRequest) {
            return back()->with('error', 'No connection request found');
        }

        if ($connectionRequest->reject()) {
            return back()->with('info', "Connection request from {$user->name} rejected.");
        }

        return back()->with('error', 'Unable to reject connection request');
    }
}
