<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create published future events
        Event::factory()
            ->published()
            ->future()
            ->count(15)
            ->create();

        // Create published past events (for testing attendance on recent events)
        Event::factory()
            ->published()
            ->past()
            ->count(8)
            ->create();

        // Create draft events
        Event::factory()
            ->draft()
            ->future()
            ->count(5)
            ->create();

        // Create some events happening today/tomorrow for testing
        Event::factory()
            ->published()
            ->count(3)
            ->create([
                'date_time' => now()->addHours(fake()->numberBetween(2, 48)),
            ]);

        // Create events from different categories for testing filters
        for ($categoryId = 1; $categoryId <= 10; $categoryId++) {
            Event::factory()
                ->published()
                ->future()
                ->count(2)
                ->create([
                    'category_id' => $categoryId,
                ]);
        }
    }
}
