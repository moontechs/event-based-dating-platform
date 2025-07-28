<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
        $timezones = ['UTC-8', 'UTC-7', 'UTC-6', 'UTC-5', 'UTC-4', 'UTC-3', 'UTC+0', 'UTC+1', 'UTC+2', 'UTC+9'];

        return [
            'title' => fake()->randomElement($eventTypes),
            'description' => fake()->sentence(12),
            'extended_description' => fake()->paragraphs(3, true),
            'image_path' => fake()->imageUrl(800, 600, 'event'),
            'date_time' => fake()->dateTimeBetween('-1 month', '+3 months'),
            'timezone' => fake()->randomElement($timezones),
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
