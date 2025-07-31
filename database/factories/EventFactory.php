<?php

namespace Database\Factories;

use App\Models\TimeZone;
use DB;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $eventTypes = [
            'Tech Meetup', 'Wine Tasting', 'Art Gallery Opening', 'Hiking Adventure',
            'Cooking Class', 'Book Club Meeting', 'Startup Pitch Night', 'Photography Walk',
            'Dance Workshop', 'Coffee & Conversation', 'Museum Tour', 'Fitness Bootcamp',
            'Networking Happy Hour', 'Comedy Show', 'Music Concert', 'Food Festival',
        ];

        $cities = ['New York', 'Los Angeles', 'Chicago', 'Houston', 'Phoenix', 'Philadelphia', 'San Antonio', 'San Diego', 'Dallas', 'San Jose'];
        $countries = ['United States', 'Canada', 'United Kingdom', 'Germany', 'France', 'Australia', 'Japan', 'Brazil'];
        $eventImages = Storage::disk('public')->files('test-events');

        return [
            'title' => fake()->randomElement($eventTypes),
            'description' => fake()->sentence(12),
            'image_path' => fake()->randomElement($eventImages),
            'date_time' => fake()->dateTimeBetween('-1 month', '+3 months'),
            'timezone_id' => fake()->randomElement(TimeZone::all())->id,
            'category_id' => fake()->numberBetween(1, 10),
            'city' => fake()->randomElement($cities),
            'country' => fake()->randomElement($countries),
            'is_published' => fake()->boolean(70),
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => true,
        ]);
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => false,
        ]);
    }

    public function future(): static
    {
        return $this->state(fn (array $attributes) => [
            'date_time' => fake()->dateTimeBetween('+1 day', '+3 months'),
        ]);
    }

    public function past(): static
    {
        return $this->state(fn (array $attributes) => [
            'date_time' => fake()->dateTimeBetween('-1 month', '-1 day'),
        ]);
    }
}
