<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TournamentController extends Controller
{
    /**
     * Display a listing of tournaments (admin)
     */
    public function index()
    {
        $tournaments = Tournament::with('creator', 'participants')
            ->orderBy('tournament_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(15);

        return view('admin.tournaments.index', compact('tournaments'));
    }

    /**
     * Show the form for creating a new tournament
     */
    public function create()
    {
        return view('admin.tournaments.create');
    }

    /**
     * Store a newly created tournament
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'tournament_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'game_mode' => 'required|in:1v1,2v2,3v3,hoops,rumble,dropshot,snowday',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['status'] = 'upcoming';
        $validated['max_participants'] = 999; // Default unlimited participants
        $validated['prize_pool'] = null; // No prize pool display

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/tournaments'), $imageName);
            $validated['image'] = 'uploads/tournaments/' . $imageName;
        }

        Tournament::create($validated);

        return redirect()->route('admin.tournaments.index')->with('success', 'Toernooi succesvol aangemaakt!');
    }

    /**
     * Show the form for editing the tournament
     */
    public function edit(Tournament $tournament)
    {
        return view('admin.tournaments.edit', compact('tournament'));
    }

    /**
     * Update the specified tournament
     */
    public function update(Request $request, Tournament $tournament)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'tournament_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'game_mode' => 'required|in:1v1,2v2,3v3,hoops,rumble,dropshot,snowday',
            'status' => 'required|in:upcoming,ongoing,completed,cancelled',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($tournament->image && file_exists(public_path($tournament->image))) {
                unlink(public_path($tournament->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/tournaments'), $imageName);
            $validated['image'] = 'uploads/tournaments/' . $imageName;
        }

        $tournament->update($validated);

        return redirect()->route('admin.tournaments.index')->with('success', 'Toernooi succesvol bijgewerkt!');
    }

    /**
     * Remove the specified tournament
     */
    public function destroy(Tournament $tournament)
    {
        // Delete image if exists
        if ($tournament->image && file_exists(public_path($tournament->image))) {
            unlink(public_path($tournament->image));
        }

        $tournament->delete();

        return redirect()->route('admin.tournaments.index')->with('success', 'Toernooi succesvol verwijderd!');
    }

    /**
     * View tournament participants
     */
    public function participants(Tournament $tournament)
    {
        $tournament->load(['participants' => function($query) {
            $query->orderBy('tournament_user.registered_at');
        }]);

        return view('admin.tournaments.participants', compact('tournament'));
    }
}
