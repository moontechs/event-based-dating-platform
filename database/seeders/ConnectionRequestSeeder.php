<?php

namespace Database\Seeders;

use App\Models\ConnectionRequest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConnectionRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users who attended the same events (eligible for connections)
        $sharedAttendances = DB::table('event_attendances as ea1')
            ->join('event_attendances as ea2', 'ea1.event_id', '=', 'ea2.event_id')
            ->where('ea1.user_id', '!=', 'ea2.user_id')
            ->join('users as u1', 'ea1.user_id', '=', 'u1.id')
            ->join('users as u2', 'ea2.user_id', '=', 'u2.id')
            ->where('u1.status', 'active')
            ->where('u2.status', 'active')
            ->select('ea1.user_id as sender_id', 'ea2.user_id as receiver_id')
            ->distinct()
            ->get()
            ->toArray();

        if (empty($sharedAttendances)) {
            return;
        }

        // Create pending connection requests
        $pendingCount = min(15, count($sharedAttendances));
        $pendingConnections = collect($sharedAttendances)->random($pendingCount);

        foreach ($pendingConnections as $connection) {
            ConnectionRequest::firstOrCreate([
                'sender_id' => $connection->sender_id,
                'receiver_id' => $connection->receiver_id,
            ], [
                'status' => 'pending',
            ]);
        }

        // Create accepted connection requests (matches)
        $acceptedCount = min(8, count($sharedAttendances) - $pendingCount);
        if ($acceptedCount > 0) {
            $remainingConnections = collect($sharedAttendances)
                ->diff($pendingConnections)
                ->random($acceptedCount);

            foreach ($remainingConnections as $connection) {
                ConnectionRequest::firstOrCreate([
                    'sender_id' => $connection->sender_id,
                    'receiver_id' => $connection->receiver_id,
                ], [
                    'status' => 'accepted',
                ]);
            }
        }

        // Create some cancelled connection requests
        $cancelledCount = min(5, count($sharedAttendances) - $pendingCount - $acceptedCount);
        if ($cancelledCount > 0) {
            $remainingConnections = collect($sharedAttendances)
                ->diff($pendingConnections)
                ->diff($remainingConnections ?? collect())
                ->random($cancelledCount);

            foreach ($remainingConnections as $connection) {
                ConnectionRequest::firstOrCreate([
                    'sender_id' => $connection->sender_id,
                    'receiver_id' => $connection->receiver_id,
                ], [
                    'status' => 'cancelled',
                ]);
            }
        }

        // Create some mutual connections (both users sent requests to each other)
        $mutualCount = min(3, count($sharedAttendances));
        $mutualConnections = collect($sharedAttendances)->random($mutualCount);

        foreach ($mutualConnections as $connection) {
            // Request from A to B
            ConnectionRequest::firstOrCreate([
                'sender_id' => $connection->sender_id,
                'receiver_id' => $connection->receiver_id,
            ], [
                'status' => 'accepted',
            ]);

            // Request from B to A
            ConnectionRequest::firstOrCreate([
                'sender_id' => $connection->receiver_id,
                'receiver_id' => $connection->sender_id,
            ], [
                'status' => 'accepted',
            ]);
        }
    }
}
