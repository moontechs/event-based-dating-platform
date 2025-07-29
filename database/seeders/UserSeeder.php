<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user with known credentials
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'full_name' => 'System Administrator',
                'whatsapp_number' => '+1234567890',
                'photo_path' => 'https://via.placeholder.com/400x400/4A90E2/FFFFFF?text=Admin',
                'relationship_intent' => 'dont_know',
                'status' => 'active',
                'terms_accepted' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create test users with various profiles
        User::factory()
            ->count(25)
            ->create([
                'status' => 'active',
                'terms_accepted' => true,
                'email_verified_at' => now(),
            ]);

        // Create some inactive users
        User::factory()
            ->count(5)
            ->create([
                'status' => 'inactive',
                'status_reason' => 'Account suspended for testing purposes',
                'terms_accepted' => true,
                'email_verified_at' => now(),
            ]);

        // Create some users who haven't accepted terms yet
        User::factory()
            ->count(10)
            ->create([
                'status' => 'inactive',
                'terms_accepted' => false,
                'email_verified_at' => now(),
            ]);

        // Create some users who haven't filled out their profile
        User::factory()
            ->count(10)
            ->create([
                'status' => 'active',
                'terms_accepted' => false,
                'email_verified_at' => now(),
                'full_name' => null,
                'whatsapp_number' => null,
                'photo_path' => null,
                'relationship_intent' => null,
            ]);

        // Create users with specific relationship intents for testing
        foreach (['monogamous', 'open_relationship', 'casual_fling'] as $intent) {
            User::factory()
                ->count(8)
                ->create([
                    'relationship_intent' => $intent,
                    'status' => 'active',
                    'terms_accepted' => true,
                    'email_verified_at' => now(),
                ]);
        }
    }
}
