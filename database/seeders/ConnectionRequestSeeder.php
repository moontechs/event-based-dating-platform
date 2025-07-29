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
            ->whereColumn('ea1.user_id', '!=', 'ea2.user_id')
            ->join('users as u1', 'ea1.user_id', '=', 'u1.id')
            ->join('users as u2', 'ea2.user_id', '=', 'u2.id')
            ->where('u1.status', '=', 'active')
            ->where('u2.status', '=', 'active')
            ->select('ea1.user_id as sender_id', 'ea2.user_id as receiver_id')
            ->distinct()
            ->limit(50)
            ->get();

        if ($sharedAttendances->isEmpty()) {
            return;
        }

        $created = collect();

        // Create some pending connection requests
        $pendingConnections = $sharedAttendances->take(15);
        foreach ($pendingConnections as $connection) {
            $key = $connection->sender_id.'-'.$connection->receiver_id;
            if (! $created->has($key)) {
                ConnectionRequest::firstOrCreate([
                    'sender_id' => $connection->sender_id,
                    'receiver_id' => $connection->receiver_id,
                ], [
                    'status' => 'pending',
                ]);
                $created->put($key, true);
            }
        }

        // Create some accepted connection requests (matches)
        $acceptedConnections = $sharedAttendances->skip(15)->take(10);
        foreach ($acceptedConnections as $connection) {
            $key = $connection->sender_id.'-'.$connection->receiver_id;
            if (! $created->has($key)) {
                ConnectionRequest::firstOrCreate([
                    'sender_id' => $connection->sender_id,
                    'receiver_id' => $connection->receiver_id,
                ], [
                    'status' => 'accepted',
                ]);
                $created->put($key, true);
            }
        }

        // Create some cancelled connection requests
        $cancelledConnections = $sharedAttendances->skip(25)->take(5);
        foreach ($cancelledConnections as $connection) {
            $key = $connection->sender_id.'-'.$connection->receiver_id;
            if (! $created->has($key)) {
                ConnectionRequest::firstOrCreate([
                    'sender_id' => $connection->sender_id,
                    'receiver_id' => $connection->receiver_id,
                ], [
                    'status' => 'cancelled',
                ]);
                $created->put($key, true);
            }
        }

        // Create some mutual connections (both users sent requests to each other)
        $mutualConnections = $sharedAttendances->skip(30)->take(5);
        foreach ($mutualConnections as $connection) {
            $keyAB = $connection->sender_id.'-'.$connection->receiver_id;
            $keyBA = $connection->receiver_id.'-'.$connection->sender_id;

            if (! $created->has($keyAB)) {
                ConnectionRequest::firstOrCreate([
                    'sender_id' => $connection->sender_id,
                    'receiver_id' => $connection->receiver_id,
                ], [
                    'status' => 'accepted',
                ]);
                $created->put($keyAB, true);
            }

            if (! $created->has($keyBA)) {
                ConnectionRequest::firstOrCreate([
                    'sender_id' => $connection->receiver_id,
                    'receiver_id' => $connection->sender_id,
                ], [
                    'status' => 'accepted',
                ]);
                $created->put($keyBA, true);
            }
        }
    }
}
