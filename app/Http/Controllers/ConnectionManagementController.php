<?php

namespace App\Http\Controllers;

use App\Enums\ConnectionStatus;
use App\Models\ConnectionRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ConnectionManagementController extends Controller
{
    public function index(): RedirectResponse
    {
        return redirect()->route('connections.incoming');
    }

    public function incoming(): View
    {
        $user = Auth::user();

        $incomingRequests = ConnectionRequest::with(['sender'])
            ->where('receiver_id', $user->id)
            ->where('status', ConnectionStatus::Pending)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('connections.incoming', compact('incomingRequests'));
    }

    public function sent(): View
    {
        $user = Auth::user();

        $sentRequests = ConnectionRequest::with(['receiver'])
            ->where('sender_id', $user->id)
            ->where('status', ConnectionStatus::Pending)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('connections.sent', compact('sentRequests'));
    }

    public function matches(): View
    {
        $user = Auth::user();

        $matches = ConnectionRequest::with(['sender', 'receiver'])
            ->where(function ($query) use ($user) {
                $query->where('sender_id', $user->id)
                    ->orWhere('receiver_id', $user->id);
            })
            ->where('status', ConnectionStatus::Accepted)
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('connections.matches', compact('matches'));
    }
}
