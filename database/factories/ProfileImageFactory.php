<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProfileImage>
 */
class ProfileImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $profileImages = File::allFiles(app_path('../example/test-profiles'));
        $selectedImage = $profileImages[array_rand($profileImages)]->getPathname();
        $newImageName = Str::random(40).'.'.pathinfo($selectedImage, PATHINFO_EXTENSION);
        File::copy($selectedImage, Storage::disk('public')->path('profile-photos/'.$newImageName));

        return [
            'user_id' => User::factory(),
            'image_path' => Arr::random('profile-photos/'.$newImageName),
            'is_main' => false,
        ];
    }

    public function main(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_main' => true,
        ]);
    }
}
