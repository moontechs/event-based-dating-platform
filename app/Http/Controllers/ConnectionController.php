<?php

namespace App\Http\Controllers;

use App\Enums\ConnectionStatus;
use App\Models\ConnectionRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ConnectionController extends Controller
{
    /**
     * Send a connection request to another user
     */
    public function sendRequest(Request $request, User $user): RedirectResponse
    {
        $sender = Auth::user();

        if ($sender->id === $user->id) {
            return back()->with('error', 'You cannot send a connection request to yourself');
        }

        if (! ConnectionRequest::areUsersEligible($sender, $user)) {
            return back()->with('error', 'You can only connect with users you\'ve attended events with');
        }

        $existingStatus = ConnectionRequest::getConnectionStatus($sender, $user);

        if ($existingStatus === ConnectionStatus::Accepted) {
            return back()->with('info', 'You are already connected with this user');
        }

        $pendingRequestAlreadyWaiting = ConnectionRequest::hasPendingRequest($sender, $user);

        if ($pendingRequestAlreadyWaiting) {
            return back()->with('info', 'A connection request is already pending between you and this user');
        }

        DB::beginTransaction();

        try {
            // Check if there's a reverse request (mutual request scenario)
            $reverseRequest = ConnectionRequest::where('sender_id', $user->id)
                ->where('receiver_id', $sender->id)
                ->where('status', ConnectionStatus::Pending)
                ->first();

            if ($reverseRequest) {
                // Mutual request - automatically accept both
                $reverseRequest->accept();

                DB::commit();

                return back()->with('success', "Great! You and {$user->name} both wanted to connect. You're now matched!");
            } else {
                // Regular request
                $connectionRequest = ConnectionRequest::createRequest($sender, $user);

                if (! $connectionRequest) {
                    DB::rollBack();

                    return back()->with('error', 'Unable to send connection request');
                }

                DB::commit();

                return back()->with('success', "Connection request sent to {$user->name}!");
            }
        } catch (\Exception $e) {
            Log::error('Error sending connection request', [
                'sender_id' => $sender->id,
                'receiver_id' => $user->id,
                'error' => $e->getMessage(),
            ]);

            DB::rollBack();

            return back()->with('error', 'An error occurred while sending the connection request');
        }
    }

    /**
     * Cancel a pending connection request
     */
    public function cancelRequest(Request $request, User $user): RedirectResponse
    {
        $sender = Auth::user();

        $connectionRequest = ConnectionRequest::where('sender_id', $sender->id)
            ->where('receiver_id', $user->id)
            ->where('status', ConnectionStatus::Pending)
            ->first();

        if (! $connectionRequest) {
            return back()->with('error', 'No pending connection request found');
        }

        if ($connectionRequest->delete()) {
            return back()->with('success', "Connection request to {$user->name} cancelled.");
        }

        return back()->with('error', 'Unable to cancel connection request');
    }

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

        if ($connectionRequest->cancel()) {
            return back()->with('info', "Connection request from {$user->name} rejected.");
        }

        return back()->with('error', 'Unable to reject connection request');
    }
}
