<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display the specified user's profile (public view)
     */
    public function show(User $user)
    {
        return view('profile.show', compact('user'));
    }

    /**
     * Show the form for editing the authenticated user's profile
     */
    public function edit(User $user)
    {
        // Alleen de eigenaar kan zijn/haar eigen profiel bewerken
        if (auth()->id() !== $user->id) {
            abort(403, 'Je hebt geen toegang om dit profiel te bewerken.');
        }

        return view('profile.edit', compact('user'));
    }

    /**
     * Update the authenticated user's profile
     */
    public function update(Request $request, User $user)
    {
        // Alleen de eigenaar kan zijn/haar eigen profiel bijwerken
        if (auth()->id() !== $user->id) {
            abort(403, 'Je hebt geen toegang om dit profiel te bewerken.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'birthday' => ['nullable', 'date', 'before:today'],
            'about_me' => ['nullable', 'string', 'max:1000'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'mmr_1v1' => ['nullable', 'integer', 'min:0', 'max:3000'],
            'mmr_2v2' => ['nullable', 'integer', 'min:0', 'max:3000'],
            'mmr_3v3' => ['nullable', 'integer', 'min:0', 'max:3000'],
            'mmr_hoops' => ['nullable', 'integer', 'min:0', 'max:3000'],
            'mmr_rumble' => ['nullable', 'integer', 'min:0', 'max:3000'],
            'mmr_dropshot' => ['nullable', 'integer', 'min:0', 'max:3000'],
            'mmr_snowday' => ['nullable', 'integer', 'min:0', 'max:3000'],
        ]);

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            // Store new photo
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $validated['profile_photo'] = $path;
        }

        $user->update($validated);

        return redirect()->route('profile.show', $user)->with('success', 'Profiel succesvol bijgewerkt!');
    }
}
