<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tournament;
use App\Models\User;
use Carbon\Carbon;

class TournamentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first admin user or create one
        $admin = User::where('is_admin', true)->first();

        if (!$admin) {
            $admin = User::first();
        }

        if (!$admin) {
            $admin = User::create([
                'name' => 'Admin User',
                'username' => 'admin',
                'email' => 'admin@rocketleague.com',
                'password' => bcrypt('password'),
                'is_admin' => true,
            ]);
        }

        $tournaments = [
            // Today's tournaments
            [
                'name' => '1v1 Duel Championship',
                'description' => 'Laat zien wat je kunt in een intense 1v1 showdown! Alleen de beste spelers overleven deze competitie.',
                'tournament_date' => Carbon::today(),
                'start_time' => '18:00:00',
                'end_time' => '22:00:00',
                'max_participants' => 32,
                'game_mode' => '1v1',
                'prize_pool' => '€100',
                'status' => 'upcoming',
                'created_by' => $admin->id,
            ],
            [
                'name' => 'Hoops Madness',
                'description' => 'Kom naar het basket in deze epische Hoops tournament. Dunk je tegenstanders en win de prijs!',
                'tournament_date' => Carbon::today(),
                'start_time' => '20:00:00',
                'end_time' => '23:00:00',
                'max_participants' => 16,
                'game_mode' => 'hoops',
                'prize_pool' => '€50',
                'status' => 'upcoming',
                'created_by' => $admin->id,
            ],

            // Tomorrow's tournaments
            [
                'name' => 'Standard 3v3 Pro League',
                'description' => 'Het belangrijkste evenement van de week! Teams van 3 strijden om de ultieme glorie en een geweldige prijzenpot.',
                'tournament_date' => Carbon::tomorrow(),
                'start_time' => '19:00:00',
                'end_time' => '23:30:00',
                'max_participants' => 48,
                'game_mode' => '3v3',
                'prize_pool' => '€250',
                'status' => 'upcoming',
                'created_by' => $admin->id,
            ],
            [
                'name' => 'Rumble Chaos Cup',
                'description' => 'Alles kan gebeuren in deze chaotische Rumble tournament! Power-ups, crazy goals en veel lol.',
                'tournament_date' => Carbon::tomorrow(),
                'start_time' => '21:00:00',
                'end_time' => '00:00:00',
                'max_participants' => 24,
                'game_mode' => 'rumble',
                'prize_pool' => '€75',
                'status' => 'upcoming',
                'created_by' => $admin->id,
            ],

            // This week
            [
                'name' => '2v2 Doubles Tournament',
                'description' => 'Vind je perfecte partner en domineer de competitie. Teamwork is de sleutel tot overwinning!',
                'tournament_date' => Carbon::today()->addDays(3),
                'start_time' => '18:30:00',
                'end_time' => '22:00:00',
                'max_participants' => 32,
                'game_mode' => '2v2',
                'prize_pool' => '€150',
                'status' => 'upcoming',
                'created_by' => $admin->id,
            ],
            [
                'name' => 'Dropshot Destruction',
                'description' => 'Breek de vloer en val je tegenstanders door de grond! De meest explosieve game mode in een tournament formaat.',
                'tournament_date' => Carbon::today()->addDays(4),
                'start_time' => '20:00:00',
                'end_time' => '23:00:00',
                'max_participants' => 16,
                'game_mode' => 'dropshot',
                'prize_pool' => '€60',
                'status' => 'upcoming',
                'created_by' => $admin->id,
            ],
            [
                'name' => 'Snow Day Winter Classic',
                'description' => 'Schaats over het ijs en sla de puck in het doel! Een ijskoude competitie met hete actie.',
                'tournament_date' => Carbon::today()->addDays(5),
                'start_time' => '19:00:00',
                'end_time' => '22:30:00',
                'max_participants' => 24,
                'game_mode' => 'snowday',
                'prize_pool' => '€80',
                'status' => 'upcoming',
                'created_by' => $admin->id,
            ],

            // Next week
            [
                'name' => 'Grand Championship Finals',
                'description' => 'Het grootste evenement van het seizoen! Alleen voor de beste spelers met minimaal Grand Champion rank.',
                'tournament_date' => Carbon::today()->addWeek(),
                'start_time' => '18:00:00',
                'end_time' => '00:00:00',
                'max_participants' => 64,
                'game_mode' => '3v3',
                'prize_pool' => '€500',
                'status' => 'upcoming',
                'created_by' => $admin->id,
            ],
            [
                'name' => 'Beginner Friendly Cup',
                'description' => 'Ben je nieuw bij competitief Rocket League? Dit is de perfecte tournament voor jou! Platinum en lager welkom.',
                'tournament_date' => Carbon::today()->addWeek()->addDays(2),
                'start_time' => '19:00:00',
                'end_time' => '22:00:00',
                'max_participants' => 32,
                'game_mode' => '2v2',
                'prize_pool' => '€50',
                'status' => 'upcoming',
                'created_by' => $admin->id,
            ],

            // Past tournament (for testing completed status)
            [
                'name' => 'Champions League Season 1',
                'description' => 'Het eerste officiële seizoen tournament. Een geweldige competitie met veel spannende momenten!',
                'tournament_date' => Carbon::yesterday(),
                'start_time' => '18:00:00',
                'end_time' => '23:00:00',
                'max_participants' => 32,
                'game_mode' => '3v3',
                'prize_pool' => '€200',
                'status' => 'completed',
                'created_by' => $admin->id,
            ],
        ];

        foreach ($tournaments as $tournamentData) {
            Tournament::create($tournamentData);
        }

        // Register some users to tournaments
        $users = User::limit(10)->get();
        $allTournaments = Tournament::all();

        foreach ($allTournaments->take(5) as $tournament) {
            $randomUsers = $users->random(min($users->count(), rand(5, 15)));
            foreach ($randomUsers as $user) {
                $tournament->participants()->attach($user->id, [
                    'registered_at' => now(),
                    'checked_in' => rand(0, 1) == 1,
                ]);
            }
        }
    }
}
