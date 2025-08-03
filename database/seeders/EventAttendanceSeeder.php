<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventAttendance;
use App\Models\User;
use Illuminate\Database\Seeder;

class EventAttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('status', 'active')
            ->whereNotNull('full_name')
            ->where('name', '!=', 'System')
            ->get();
        $events = Event::where('is_published', true)->get();

        // Generate realistic attendance patterns
        foreach ($events as $event) {
            // Each event gets 0-15 attendees
            $attendeeCount = fake()->numberBetween(0, 15);
            $selectedUsers = $users->random($attendeeCount);

            foreach ($selectedUsers as $user) {
                EventAttendance::firstOrCreate([
                    'user_id' => $user->id,
                    'event_id' => $event->id,
                ]);
            }
        }

        // Ensure some users attend multiple events (for connection testing)
        $activeUsers = $users->take(20);
        foreach ($activeUsers as $user) {
            $userEvents = $events->random(fake()->numberBetween(2, 6));
            foreach ($userEvents as $event) {
                EventAttendance::firstOrCreate([
                    'user_id' => $user->id,
                    'event_id' => $event->id,
                ]);
            }
        }

        // Create some shared attendance patterns for connection testing
        $testUsers = $users->take(10);
        $sharedEvents = $events->take(5);

        foreach ($sharedEvents as $event) {
            foreach ($testUsers as $user) {
                if (fake()->boolean(70)) { // 70% chance of attendance
                    EventAttendance::firstOrCreate([
                        'user_id' => $user->id,
                        'event_id' => $event->id,
                    ]);
                }
            }
        }
    }
}
