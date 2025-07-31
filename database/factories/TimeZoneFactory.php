<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TimeZone>
 */
class TimeZoneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // should be supported by PHP https://www.php.net/manual/en/timezones.php
        $timezones = [
            ['name' => 'Africa/Cairo', 'display_name' => '(UTC+2) Eastern European Time', 'utc_offset' => 'UTC+2'],
            ['name' => 'America/Chicago', 'display_name' => '(UTC-6) Central Standard Time', 'utc_offset' => 'UTC-6'],
            ['name' => 'America/Denver', 'display_name' => '(UTC-7) Mountain Standard Time', 'utc_offset' => 'UTC-7'],
            ['name' => 'America/Los_Angeles', 'display_name' => '(UTC-8) Pacific Standard Time', 'utc_offset' => 'UTC-8'],
            ['name' => 'America/New_York', 'display_name' => '(UTC-5) Eastern Standard Time', 'utc_offset' => 'UTC-5'],
            ['name' => 'Asia/Shanghai', 'display_name' => '(UTC+8) China Standard Time', 'utc_offset' => 'UTC+8'],
            ['name' => 'Asia/Tokyo', 'display_name' => '(UTC+9) Japan Standard Time', 'utc_offset' => 'UTC+9'],
            ['name' => 'Australia/Sydney', 'display_name' => '(UTC+10) Australian Eastern Standard Time', 'utc_offset' => 'UTC+10'],
            ['name' => 'Europe/Berlin', 'display_name' => '(UTC+1) Central European Time', 'utc_offset' => 'UTC+1'],
            ['name' => 'Europe/London', 'display_name' => '(UTC+0) Greenwich Mean Time', 'utc_offset' => 'UTC+0'],
            ['name' => 'Europe/Paris', 'display_name' => '(UTC+1) Central European Time', 'utc_offset' => 'UTC+1'],
        ];

        $timezone = fake()->randomElement($timezones);

        return [
            'name' => $timezone['name'],
            'display_name' => $timezone['display_name'],
            'utc_offset' => $timezone['utc_offset'],
            'is_active' => fake()->boolean(95),
        ];
    }

    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
