<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Always run production seeders (required for all environments)
        $this->call([
            TimeZoneSeeder::class,
            EventCategorySeeder::class,
        ]);

        // Run development seeders only in local/staging environments
        if (app()->environment(['local', 'staging'])) {
            $this->call([
                UserSeeder::class,
                EventSeeder::class,
                EventAttendanceSeeder::class,
                ConnectionRequestSeeder::class,
            ]);
        }
    }
}
