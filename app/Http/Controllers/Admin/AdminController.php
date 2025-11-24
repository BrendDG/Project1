<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Nieuws;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    /**
     * Toon het admin dashboard
     */
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalAdmins = User::where('is_admin', true)->count();
        $recentUsers = User::latest()->take(5)->get();

        // Nieuws statistieken
        $totalNieuws = Nieuws::count();
        $publishedNieuws = Nieuws::where('published_at', '<=', now())->count();
        $scheduledNieuws = Nieuws::where('published_at', '>', now())->count();
        $recentNieuws = Nieuws::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalAdmins',
            'recentUsers',
            'totalNieuws',
            'publishedNieuws',
            'scheduledNieuws',
            'recentNieuws'
        ));
    }

    /**
     * Toon alle gebruikers
     */
    public function users(Request $request)
    {
        $query = User::query();

        // Zoekfunctionaliteit
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%");
            });
        }

        // Filter op admin status
        if ($request->has('admin_filter')) {
            if ($request->admin_filter === 'admins') {
                $query->where('is_admin', true);
            } elseif ($request->admin_filter === 'users') {
                $query->where('is_admin', false);
            }
        }

        $users = $query->latest()->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Toon formulier voor nieuwe gebruiker
     */
    public function createUser()
    {
        return view('admin.users.create');
    }

    /**
     * Sla nieuwe gebruiker op
     */
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['nullable', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'is_admin' => ['boolean'],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_admin'] = $request->has('is_admin');

        User::create($validated);

        return redirect()->route('admin.users')->with('success', 'Gebruiker succesvol aangemaakt!');
    }

    /**
     * Toon formulier voor gebruiker bewerken
     */
    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update gebruiker
     */
    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'username' => ['nullable', 'string', 'max:255', 'unique:users,username,' . $user->id],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'is_admin' => ['boolean'],
        ]);

        // Voorkom dat een admin zichzelf degradeert als het de enige admin is
        if ($user->id === auth()->id() && !$request->has('is_admin')) {
            $otherAdminsCount = User::where('is_admin', true)->where('id', '!=', $user->id)->count();
            if ($otherAdminsCount === 0) {
                return back()->withErrors(['is_admin' => 'Je kunt jezelf niet degraderen als je de enige admin bent.']);
            }
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['is_admin'] = $request->has('is_admin');

        $user->update($validated);

        return redirect()->route('admin.users')->with('success', 'Gebruiker succesvol bijgewerkt!');
    }

    /**
     * Verwijder gebruiker
     */
    public function destroyUser(User $user)
    {
        // Voorkom dat een admin zichzelf verwijdert
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Je kunt jezelf niet verwijderen.');
        }

        // Voorkom dat de laatste admin wordt verwijderd
        if ($user->is_admin) {
            $otherAdminsCount = User::where('is_admin', true)->where('id', '!=', $user->id)->count();
            if ($otherAdminsCount === 0) {
                return back()->with('error', 'Je kunt de laatste admin niet verwijderen.');
            }
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Gebruiker succesvol verwijderd!');
    }

    /**
     * Toggle admin status van een gebruiker
     */
    public function toggleAdmin(User $user)
    {
        // Voorkom dat een admin zichzelf degradeert als het de enige admin is
        if ($user->is_admin && $user->id === auth()->id()) {
            $otherAdminsCount = User::where('is_admin', true)->where('id', '!=', $user->id)->count();
            if ($otherAdminsCount === 0) {
                return back()->with('error', 'Je kunt jezelf niet degraderen als je de enige admin bent.');
            }
        }

        $user->is_admin = !$user->is_admin;
        $user->save();

        $message = $user->is_admin
            ? "Gebruiker {$user->name} is nu een admin."
            : "Admin rechten van {$user->name} zijn ingetrokken.";

        return back()->with('success', $message);
    }

    // ==================== NIEUWS BEHEER ====================

    /**
     * Toon alle nieuwsitems
     */
    public function nieuws(Request $request)
    {
        $query = Nieuws::query();

        // Zoekfunctionaliteit
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Filter op publicatie status
        if ($request->has('status_filter')) {
            if ($request->status_filter === 'published') {
                $query->where('published_at', '<=', now());
            } elseif ($request->status_filter === 'scheduled') {
                $query->where('published_at', '>', now());
            }
        }

        $nieuwsItems = $query->latest('created_at')->paginate(15);

        return view('admin.nieuws.index', compact('nieuwsItems'));
    }

    /**
     * Toon formulier voor nieuw nieuwsitem
     */
    public function createNieuws()
    {
        return view('admin.nieuws.create');
    }

    /**
     * Sla nieuw nieuwsitem op
     */
    public function storeNieuws(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif', 'max:2048'],
            'published_at' => ['required', 'date'],
        ]);

        // Upload afbeelding
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('nieuws', 'public');
        }

        Nieuws::create($validated);

        return redirect()->route('admin.nieuws')->with('success', 'Nieuwsitem succesvol aangemaakt!');
    }

    /**
     * Toon formulier voor nieuwsitem bewerken
     */
    public function editNieuws(Nieuws $nieuws)
    {
        return view('admin.nieuws.edit', compact('nieuws'));
    }

    /**
     * Update nieuwsitem
     */
    public function updateNieuws(Request $request, Nieuws $nieuws)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif', 'max:2048'],
            'published_at' => ['required', 'date'],
        ]);

        // Upload nieuwe afbeelding
        if ($request->hasFile('image')) {
            // Verwijder oude afbeelding
            if ($nieuws->image) {
                Storage::disk('public')->delete($nieuws->image);
            }
            $validated['image'] = $request->file('image')->store('nieuws', 'public');
        }

        $nieuws->update($validated);

        return redirect()->route('admin.nieuws')->with('success', 'Nieuwsitem succesvol bijgewerkt!');
    }

    /**
     * Verwijder nieuwsitem
     */
    public function destroyNieuws(Nieuws $nieuws)
    {
        // Verwijder afbeelding
        if ($nieuws->image) {
            Storage::disk('public')->delete($nieuws->image);
        }

        $nieuws->delete();

        return redirect()->route('admin.nieuws')->with('success', 'Nieuwsitem succesvol verwijderd!');
    }
}
