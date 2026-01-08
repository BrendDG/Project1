<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin gebruiker
        User::updateOrCreate(
            ['email' => 'admin@ehb.be'],
            [
                'name' => 'Admin User',
                'username' => 'admin',
                'password' => Hash::make('Password!321'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        // Test gebruiker 1
        User::updateOrCreate(
            ['email' => 'Test@gmail.com'],
            [
                'name' => 'Zen',
                'username' => 'Zen',
                'password' => Hash::make('Test1234'),
                'is_admin' => false,
                'email_verified_at' => now(),
            ]
        );

        // Test gebruiker 2
        User::updateOrCreate(
            ['email' => 'drali@gmail.com'],
            [
                'name' => 'Drali',
                'username' => 'Drali',
                'password' => Hash::make('drali1234'),
                'is_admin' => false,
                'email_verified_at' => now(),
            ]
        );
    }
}
