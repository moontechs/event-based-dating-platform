<?php

namespace App\Services;

use App\Enums\ConnectionStatus;
use App\Models\ConnectionRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ConnectionService
{
    public function sendConnectionRequest(User $sender, User $receiver): array
    {
        if ($sender->id === $receiver->id) {
            return [
                'success' => false,
                'message' => 'You cannot send a connection request to yourself',
            ];
        }

        if (! ConnectionRequest::areUsersEligible($sender, $receiver)) {
            return [
                'success' => false,
                'message' => 'You can only connect with users you\'ve attended events with',
            ];
        }

        $existingStatus = ConnectionRequest::getConnectionStatus($sender, $receiver);

        if ($existingStatus === ConnectionStatus::Accepted) {
            return [
                'success' => false,
                'message' => 'You are already connected with this user',
            ];
        }

        if (ConnectionRequest::hasPendingRequest($sender, $receiver)) {
            return [
                'success' => false,
                'message' => 'A connection request is already pending between you and this user',
            ];
        }

        DB::beginTransaction();

        try {
            $reverseRequest = ConnectionRequest::where('sender_id', $receiver->id)
                ->where('receiver_id', $sender->id)
                ->where('status', ConnectionStatus::Pending)
                ->first();

            if ($reverseRequest) {
                $reverseRequest->accept();
                DB::commit();

                return [
                    'success' => true,
                    'message' => "Great! You and {$receiver->name} both wanted to connect. You're now matched!",
                ];
            } else {
                $connectionRequest = ConnectionRequest::createRequest($sender, $receiver);

                if (! $connectionRequest) {
                    DB::rollBack();

                    return [
                        'success' => false,
                        'message' => 'Unable to send connection request',
                    ];
                }

                DB::commit();

                return [
                    'success' => true,
                    'message' => "Connection request sent to {$receiver->name}!",
                ];
            }
        } catch (\Exception $e) {
            Log::error('Error sending connection request', [
                'sender_id' => $sender->id,
                'receiver_id' => $receiver->id,
                'error' => $e->getMessage(),
            ]);

            DB::rollBack();

            return [
                'success' => false,
                'message' => 'An error occurred while sending the connection request',
            ];
        }
    }

    public function cancelConnectionRequest(User $sender, User $receiver): array
    {
        $connectionRequest = ConnectionRequest::where('sender_id', $sender->id)
            ->where('receiver_id', $receiver->id)
            ->where('status', ConnectionStatus::Pending)
            ->first();

        if (! $connectionRequest) {
            return [
                'success' => false,
                'message' => 'No pending connection request found',
            ];
        }

        if ($connectionRequest->delete()) {
            return [
                'success' => true,
                'message' => "Connection request to {$receiver->name} cancelled.",
            ];
        }

        return [
            'success' => false,
            'message' => 'Unable to cancel connection request',
        ];
    }

    public function acceptConnectionRequest(User $receiver, User $sender): array
    {
        $connectionRequest = ConnectionRequest::where('sender_id', $sender->id)
            ->where('receiver_id', $receiver->id)
            ->where('status', ConnectionStatus::Pending)
            ->first();

        if (! $connectionRequest) {
            return [
                'success' => false,
                'message' => 'No pending connection request found',
            ];
        }

        if ($connectionRequest->accept()) {
            return [
                'success' => true,
                'message' => "You and {$sender->name} are now connected!",
            ];
        }

        return [
            'success' => false,
            'message' => 'Unable to accept connection request',
        ];
    }

    public function rejectConnectionRequest(User $receiver, User $sender): array
    {
        $connectionRequest = ConnectionRequest::where('sender_id', $sender->id)
            ->where('receiver_id', $receiver->id)
            ->whereIn('status', [ConnectionStatus::Pending, ConnectionStatus::Accepted])
            ->first();

        if (! $connectionRequest) {
            return [
                'success' => false,
                'message' => 'No connection request found',
            ];
        }

        if ($connectionRequest->reject()) {
            return [
                'success' => true,
                'message' => "Connection request from {$sender->name} rejected.",
            ];
        }

        return [
            'success' => false,
            'message' => 'Unable to reject connection request',
        ];
    }

    public function getConnectionRequestData(User $user): array
    {
        $acceptedConnectionRequestUserIds = [];
        $pendingConnectionRequestUserIds = [];

        $user->acceptedConnectionRequests()->get()->each(function (ConnectionRequest $connection) use (&$acceptedConnectionRequestUserIds, $user) {
            $acceptedConnectionRequestUserIds[] = $connection->receiver_id === $user->id ? $connection->sender_id : $connection->receiver_id;
        });

        $user->sentConnectionRequests()->get()->each(function (ConnectionRequest $connection) use (&$pendingConnectionRequestUserIds) {
            if (! $connection->isPending()) {
                return;
            }

            $pendingConnectionRequestUserIds[] = $connection->receiver_id;
        });

        return [
            'accepted' => $acceptedConnectionRequestUserIds,
            'pending' => $pendingConnectionRequestUserIds,
        ];
    }
}
