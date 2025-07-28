<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimeZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timezones = [
            // North America
            ['name' => 'America/New_York', 'display_name' => '(UTC-5) Eastern Standard Time', 'utc_offset' => 'UTC-5'],
            ['name' => 'America/Chicago', 'display_name' => '(UTC-6) Central Standard Time', 'utc_offset' => 'UTC-6'],
            ['name' => 'America/Denver', 'display_name' => '(UTC-7) Mountain Standard Time', 'utc_offset' => 'UTC-7'],
            ['name' => 'America/Los_Angeles', 'display_name' => '(UTC-8) Pacific Standard Time', 'utc_offset' => 'UTC-8'],
            ['name' => 'America/Phoenix', 'display_name' => '(UTC-7) Mountain Standard Time', 'utc_offset' => 'UTC-7'],
            ['name' => 'America/Toronto', 'display_name' => '(UTC-5) Eastern Standard Time', 'utc_offset' => 'UTC-5'],
            ['name' => 'America/Vancouver', 'display_name' => '(UTC-8) Pacific Standard Time', 'utc_offset' => 'UTC-8'],

            // Europe
            ['name' => 'Europe/London', 'display_name' => '(UTC+0) Greenwich Mean Time', 'utc_offset' => 'UTC+0'],
            ['name' => 'Europe/Paris', 'display_name' => '(UTC+1) Central European Time', 'utc_offset' => 'UTC+1'],
            ['name' => 'Europe/Berlin', 'display_name' => '(UTC+1) Central European Time', 'utc_offset' => 'UTC+1'],
            ['name' => 'Europe/Rome', 'display_name' => '(UTC+1) Central European Time', 'utc_offset' => 'UTC+1'],
            ['name' => 'Europe/Madrid', 'display_name' => '(UTC+1) Central European Time', 'utc_offset' => 'UTC+1'],
            ['name' => 'Europe/Amsterdam', 'display_name' => '(UTC+1) Central European Time', 'utc_offset' => 'UTC+1'],
            ['name' => 'Europe/Moscow', 'display_name' => '(UTC+3) Moscow Standard Time', 'utc_offset' => 'UTC+3'],

            // Asia
            ['name' => 'Asia/Tokyo', 'display_name' => '(UTC+9) Japan Standard Time', 'utc_offset' => 'UTC+9'],
            ['name' => 'Asia/Shanghai', 'display_name' => '(UTC+8) China Standard Time', 'utc_offset' => 'UTC+8'],
            ['name' => 'Asia/Hong_Kong', 'display_name' => '(UTC+8) Hong Kong Time', 'utc_offset' => 'UTC+8'],
            ['name' => 'Asia/Singapore', 'display_name' => '(UTC+8) Singapore Standard Time', 'utc_offset' => 'UTC+8'],
            ['name' => 'Asia/Seoul', 'display_name' => '(UTC+9) Korea Standard Time', 'utc_offset' => 'UTC+9'],
            ['name' => 'Asia/Mumbai', 'display_name' => '(UTC+5:30) India Standard Time', 'utc_offset' => 'UTC+5:30'],
            ['name' => 'Asia/Dubai', 'display_name' => '(UTC+4) Gulf Standard Time', 'utc_offset' => 'UTC+4'],

            // Australia & Oceania
            ['name' => 'Australia/Sydney', 'display_name' => '(UTC+10) Australian Eastern Standard Time', 'utc_offset' => 'UTC+10'],
            ['name' => 'Australia/Melbourne', 'display_name' => '(UTC+10) Australian Eastern Standard Time', 'utc_offset' => 'UTC+10'],
            ['name' => 'Australia/Perth', 'display_name' => '(UTC+8) Australian Western Standard Time', 'utc_offset' => 'UTC+8'],
            ['name' => 'Pacific/Auckland', 'display_name' => '(UTC+12) New Zealand Standard Time', 'utc_offset' => 'UTC+12'],

            // South America
            ['name' => 'America/Sao_Paulo', 'display_name' => '(UTC-3) Brasilia Time', 'utc_offset' => 'UTC-3'],
            ['name' => 'America/Buenos_Aires', 'display_name' => '(UTC-3) Argentina Time', 'utc_offset' => 'UTC-3'],
            ['name' => 'America/Lima', 'display_name' => '(UTC-5) Peru Time', 'utc_offset' => 'UTC-5'],

            // Africa
            ['name' => 'Africa/Cairo', 'display_name' => '(UTC+2) Eastern European Time', 'utc_offset' => 'UTC+2'],
            ['name' => 'Africa/Johannesburg', 'display_name' => '(UTC+2) South Africa Standard Time', 'utc_offset' => 'UTC+2'],
            ['name' => 'Africa/Lagos', 'display_name' => '(UTC+1) West Africa Time', 'utc_offset' => 'UTC+1'],

            // UTC
            ['name' => 'UTC', 'display_name' => '(UTC+0) Coordinated Universal Time', 'utc_offset' => 'UTC+0'],
        ];

        foreach ($timezones as $timezone) {
            DB::table('time_zones')->updateOrInsert(
                ['name' => $timezone['name']],
                [
                    'display_name' => $timezone['display_name'],
                    'utc_offset' => $timezone['utc_offset'],
                    'is_active' => true,
                ]
            );
        }
    }
}
