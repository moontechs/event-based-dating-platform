<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Networking',
            'Social Meetup',
            'Professional',
            'Recreation & Hobbies',
            'Cultural & Arts',
            'Sports & Fitness',
            'Food & Dining',
            'Educational',
            'Entertainment',
            'Other',
        ];

        foreach ($categories as $category) {
            DB::table('event_categories')->updateOrInsert(
                ['name' => $category],
                ['is_active' => true, 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
