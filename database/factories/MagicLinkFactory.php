<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MagicLink>
 */
class MagicLinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => fake()->safeEmail(),
            'token' => Str::random(64),
            'expires_at' => now()->addMinutes(30),
            'used_at' => fake()->optional(0.4)->dateTimeBetween('-1 hour', 'now'),
            'created_at' => fake()->dateTimeBetween('-1 day', 'now'),
        ];
    }

    public function unused(): static
    {
        return $this->state(fn (array $attributes) => [
            'used_at' => null,
        ]);
    }

    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'expires_at' => fake()->dateTimeBetween('-2 hours', '-1 hour'),
            'used_at' => null,
        ]);
    }
}
