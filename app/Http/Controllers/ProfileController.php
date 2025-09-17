<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'no_hp' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];

        if ($user->role === 'mahasiswa') {
            $rules['NIM'] = 'required|string|max:50|unique:users,NIM,' . $user->id;
            $rules['prodi'] = 'required|string|max:100';
        } elseif ($user->role === 'dosen') {
            $rules['NIDN'] = 'required|string|max:50|unique:users,NIDN,' . $user->id;
            $rules['bidang_keahlian'] = 'required|string|max:100';
        }

        $validated = $request->validate($rules);

        // Upload foto
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('profile_pictures', 'public');
            $validated['foto'] = $foto;
        }

        $user->update($validated);

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
