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
        User::create([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@ehb.be',
            'password' => Hash::make('Password!321'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        // Test gebruiker 1 - Met volledig profiel
        User::create([
            'name' => 'John Doe',
            'username' => 'RocketMaster',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'birthday' => '1995-06-15',
            'about_me' => 'Gepassioneerde Rocket League speler sinds 2015. Ik hou van competitief spelen en werk graag samen met mijn team. Mijn favoriete modus is 3v3 Standard.',
            'email_verified_at' => now(),
        ]);

        // Test gebruiker 2 - Met basis profiel
        User::create([
            'name' => 'Jane Smith',
            'username' => 'AerialQueen',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
            'birthday' => '1998-03-22',
            'about_me' => 'Freestyle specialist en content creator.',
            'email_verified_at' => now(),
        ]);

        // Test gebruiker 3 - Zonder optionele velden
        User::create([
            'name' => 'Bob Johnson',
            'email' => 'bob@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Test gebruiker 4 - Voor testing
        User::create([
            'name' => 'Test User',
            'username' => 'TestPlayer',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'birthday' => '2000-01-01',
            'about_me' => 'Dit is een test account voor ontwikkeling.',
            'email_verified_at' => now(),
        ]);
    }
}
