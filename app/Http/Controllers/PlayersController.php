<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PlayersController extends Controller
{
    /**
     * Display a listing of players with search functionality
     */
    public function index(Request $request)
    {
        // Validate search input (client-side validation + server-side)
        $validated = $request->validate([
            'search' => 'nullable|string|max:255',
        ]);

        $search = $validated['search'] ?? null;

        $players = User::query()
            ->when($search, function ($query, $search) {
                // XSS protection via Laravel's automatic escaping in views
                $query->where('username', 'LIKE', "%{$search}%")
                      ->orWhere('name', 'LIKE', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString(); // Preserve search query in pagination links

        return view('players.index', compact('players', 'search'));
    }

    /**
     * Display the specified player's profile
     */
    public function show(User $user)
    {
        // Prepare all game modes with their ranks
        $gameModes = [
            [
                'name' => '1v1 Duel',
                'slug' => '1v1',
                'mmr' => $user->mmr_1v1,
                'rank' => $user->getRankFromMMR($user->mmr_1v1),
                'division' => $user->getDivisionText($user->mmr_1v1),
                'image' => $user->getRankImage($user->mmr_1v1),
            ],
            [
                'name' => '2v2 Doubles',
                'slug' => '2v2',
                'mmr' => $user->mmr_2v2,
                'rank' => $user->getRankFromMMR($user->mmr_2v2),
                'division' => $user->getDivisionText($user->mmr_2v2),
                'image' => $user->getRankImage($user->mmr_2v2),
            ],
            [
                'name' => '3v3 Standard',
                'slug' => '3v3',
                'mmr' => $user->mmr_3v3,
                'rank' => $user->getRankFromMMR($user->mmr_3v3),
                'division' => $user->getDivisionText($user->mmr_3v3),
                'image' => $user->getRankImage($user->mmr_3v3),
            ],
            [
                'name' => 'Hoops',
                'slug' => 'hoops',
                'mmr' => $user->mmr_hoops,
                'rank' => $user->getRankFromMMR($user->mmr_hoops),
                'division' => $user->getDivisionText($user->mmr_hoops),
                'image' => $user->getRankImage($user->mmr_hoops),
            ],
            [
                'name' => 'Rumble',
                'slug' => 'rumble',
                'mmr' => $user->mmr_rumble,
                'rank' => $user->getRankFromMMR($user->mmr_rumble),
                'division' => $user->getDivisionText($user->mmr_rumble),
                'image' => $user->getRankImage($user->mmr_rumble),
            ],
            [
                'name' => 'Dropshot',
                'slug' => 'dropshot',
                'mmr' => $user->mmr_dropshot,
                'rank' => $user->getRankFromMMR($user->mmr_dropshot),
                'division' => $user->getDivisionText($user->mmr_dropshot),
                'image' => $user->getRankImage($user->mmr_dropshot),
            ],
            [
                'name' => 'Snow Day',
                'slug' => 'snowday',
                'mmr' => $user->mmr_snowday,
                'rank' => $user->getRankFromMMR($user->mmr_snowday),
                'division' => $user->getDivisionText($user->mmr_snowday),
                'image' => $user->getRankImage($user->mmr_snowday),
            ],
            [
                'name' => 'Tournament',
                'slug' => 'tournament',
                'mmr' => $user->mmr_tournament,
                'rank' => $user->getRankFromMMR($user->mmr_tournament),
                'division' => $user->getDivisionText($user->mmr_tournament),
                'image' => $user->getRankImage($user->mmr_tournament),
            ],
        ];

        return view('players.show', compact('user', 'gameModes'));
    }
}
