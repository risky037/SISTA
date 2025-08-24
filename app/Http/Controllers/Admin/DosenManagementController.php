<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DosenManagementController extends Controller
{
    public function index()
    {
        $dosen = User::where('role', 'dosen')->get();
        return view('admin.management.dosen.index', compact('dosen'));
    }

    public function create()
    {
        return view('admin.management.dosen.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'no_hp' => 'nullable|string',
            'NIDN' => 'required|numeric|digits_between:8,10|unique:users,NIDN',
            'bidang_keahlian' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $data['role'] = 'dosen';

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('profile_pictures', 'public');
        }

        User::create($data);

        return redirect()->route('admin.management.dosen.index')->with('success', 'Dosen berhasil ditambahkan.');
    }

    public function edit(User $dosen)
    {
        return view('admin.management.dosen.edit', compact('dosen'));
    }

    public function update(Request $request, User $dosen)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $dosen->id,
            'password' => 'nullable|min:6',
            'no_hp' => 'nullable|string',
            'NIDN' => 'required|numeric|digits_between:8,10|unique:users,NIDN,' . $dosen->id,
            'bidang_keahlian' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $data = $request->except(['_token', '_method', 'password']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {
            if ($dosen->foto) {
                Storage::disk('public')->delete($dosen->foto);
            }
            $data['foto'] = $request->file('foto')->store('profile_pictures', 'public');
        }

        $dosen->update($data);

        return redirect()->route('admin.management.dosen.index')->with('success', "Data Dosen \"{$dosen->name}\" berhasil diperbarui.");
    }

    public function destroy(User $dosen)
    {
        if ($dosen->foto) {
            Storage::disk('public')->delete($dosen->foto);
        }
        $dosen->delete();
        return redirect()->route('admin.management.dosen.index')->with('success', "Data Dosen \"{$dosen->name}\" berhasil diperbarui.");
    }
}