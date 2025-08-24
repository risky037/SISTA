<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MahasiswaManagementController extends Controller
{
    public function index()
    {
        $mahasiswa = User::where('role', 'mahasiswa')->latest()->paginate(10);
        return view('admin.management.mahasiswa.index', compact('mahasiswa'));
    }

    public function create()
    {
        return view('admin.management.mahasiswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'no_hp' => 'nullable|string',
            'NIM' => 'required|numeric|digits_between:12,15|unique:users,NIM',
            'prodi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $data['role'] = 'mahasiswa';

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('profile_pictures', 'public');
        }

        User::create($data);

        return redirect()->route('admin.management.mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan');
    }

    public function edit($id)
    {
        $mahasiswa = User::where('role', 'mahasiswa')->findOrFail($id);
        return view('admin.management.mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, User $mahasiswa)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$mahasiswa->id,
            'no_hp' => 'nullable|string',
            'NIM' => 'required|numeric|digits_between:12,15|unique:users,NIM,' . $mahasiswa->id,
            'prodi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $data = $request->all();

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('profile_pictures', 'public');
        }

        $mahasiswa->update($data);

        return redirect()->route('admin.management.mahasiswa.index')->with('success', "Data Mahasiswa \"{$mahasiswa->name}\" berhasil diperbarui.");
    }

    public function destroy(User $mahasiswa)
    {
        $mahasiswaName = $mahasiswa->name;
        $mahasiswa->delete();

        return redirect()->route('admin.management.mahasiswa.index')->with('success', "Mahasiswa \"$mahasiswaName\" berhasil dihapus.");
    }
}
