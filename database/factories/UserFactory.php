<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make(Str::random(40)),
            'full_name' => fake()->name(),
            'whatsapp_number' => fake()->phoneNumber(),
            'photo_path' => fake()->imageUrl(400, 400, 'people'),
            'relationship_intent' => fake()->randomElement(['dont_know', 'monogamous', 'open_relationship', 'casual_fling']),
            'status' => fake()->randomElement(['active', 'inactive']),
            'status_reason' => fake()->optional(0.3)->sentence(),
            'terms_accepted' => fake()->boolean(80),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
