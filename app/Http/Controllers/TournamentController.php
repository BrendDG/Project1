<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TournamentController extends Controller
{
    /**
     * Display a listing of tournaments
     */
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'all');
        $gameMode = $request->get('game_mode', 'all');

        $query = Tournament::with('creator', 'participants');

        // Apply status filter
        switch ($filter) {
            case 'upcoming':
                $query->upcoming();
                break;
            case 'ongoing':
                $query->ongoing();
                break;
            case 'completed':
                $query->completed();
                break;
            case 'my-tournaments':
                if (Auth::check()) {
                    $query->whereHas('participants', function($q) {
                        $q->where('user_id', Auth::id());
                    })->orderBy('tournament_date')->orderBy('start_time');
                }
                break;
            default:
                $query->orderBy('tournament_date')->orderBy('start_time');
        }

        // Apply game mode filter
        if ($gameMode !== 'all') {
            $query->where('game_mode', $gameMode);
        }

        $tournaments = $query->paginate(12)->withQueryString();

        return view('tournaments.index', compact('tournaments', 'filter', 'gameMode'));
    }

    /**
     * Display the specified tournament
     */
    public function show(Tournament $tournament)
    {
        $tournament->load('creator', 'participants');

        $isRegistered = false;
        if (Auth::check()) {
            $isRegistered = $tournament->isUserRegistered(Auth::id());
        }

        return view('tournaments.show', compact('tournament', 'isRegistered'));
    }

    /**
     * Register the authenticated user for a tournament
     */
    public function register(Request $request, Tournament $tournament)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Je moet ingelogd zijn om te registreren voor een toernooi.');
        }

        // Check if tournament is full
        if ($tournament->isFull()) {
            return back()->with('error', 'Dit toernooi is vol.');
        }

        // Check if user is already registered
        if ($tournament->isUserRegistered(Auth::id())) {
            return back()->with('error', 'Je bent al geregistreerd voor dit toernooi.');
        }

        // Check if tournament is still upcoming
        if ($tournament->status !== 'upcoming') {
            return back()->with('error', 'Registratie is niet meer mogelijk voor dit toernooi.');
        }

        // Register user
        $tournament->participants()->attach(Auth::id(), [
            'registered_at' => now(),
        ]);

        return back()->with('success', 'Je bent succesvol geregistreerd voor dit toernooi!');
    }

    /**
     * Unregister the authenticated user from a tournament
     */
    public function unregister(Request $request, Tournament $tournament)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Je moet ingelogd zijn.');
        }

        if (!$tournament->isUserRegistered(Auth::id())) {
            return back()->with('error', 'Je bent niet geregistreerd voor dit toernooi.');
        }

        // Check if tournament is still upcoming
        if ($tournament->status !== 'upcoming') {
            return back()->with('error', 'Je kunt je niet meer uitschrijven voor dit toernooi.');
        }

        $tournament->participants()->detach(Auth::id());

        return back()->with('success', 'Je bent uitgeschreven voor dit toernooi.');
    }

    /**
     * Show the form for creating a new tournament (admin only)
     */
    public function create()
    {
        return view('tournaments.create');
    }

    /**
     * Store a newly created tournament (admin only)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'tournament_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'max_participants' => 'required|integer|min:4|max:128',
            'game_mode' => 'required|in:1v1,2v2,3v3,hoops,rumble,dropshot,snowday',
            'prize_pool' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['status'] = 'upcoming';

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
     * Show the form for editing a tournament (admin only)
     */
    public function edit(Tournament $tournament)
    {
        return view('tournaments.edit', compact('tournament'));
    }

    /**
     * Update the specified tournament (admin only)
     */
    public function update(Request $request, Tournament $tournament)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'tournament_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'max_participants' => 'required|integer|min:4|max:128',
            'game_mode' => 'required|in:1v1,2v2,3v3,hoops,rumble,dropshot,snowday',
            'prize_pool' => 'nullable|string|max:100',
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
     * Remove the specified tournament (admin only)
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
}
