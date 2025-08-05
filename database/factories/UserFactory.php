<?php

namespace Database\Factories;

use App\Models\ProfileImage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
            'relationship_intent' => fake()->randomElement(['serious_relationship', 'marriage', 'casual_dates', 'dont_know']),
            'age' => fake()->numberBetween(18, 65),
            'gender' => fake()->randomElement(['male', 'female', 'other']),
            'sexual_preference' => fake()->randomElement(['heterosexual', 'homosexual', 'bisexual', 'other']),
            'status' => fake()->randomElement(['active', 'inactive']),
            'status_reason' => fake()->optional(0.3)->sentence(),
            'terms_accepted' => fake()->boolean(80),
            'remember_token' => Str::random(10),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($user) {
            $imageCount = fake()->numberBetween(2, 4);
            $availableImages = Storage::disk('public')->files('test-profiles');

            $selectedImages = Arr::random($availableImages, min($imageCount, count($availableImages)));

            // If we need more images than available, repeat some
            while (count($selectedImages) < $imageCount) {
                $selectedImages[] = Arr::random($availableImages);
            }

            foreach ($selectedImages as $index => $imagePath) {
                ProfileImage::create([
                    'user_id' => $user->id,
                    'image_path' => $imagePath,
                    'is_main' => $index === 0, // First image is main
                ]);
            }
        });
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
