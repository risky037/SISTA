<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminManagementController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 'admin')->paginate(10);
        return view('admin.management.admin.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.management.admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        return redirect()->route('admin.management.admin.index')->with('success', 'Berhasil menambahkan admin baru');
    }

    public function edit(User $admin)
    {
        return view('admin.management.admin.edit', compact('admin'));
    }

    public function update(Request $request, User $admin)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $admin->id,
        ]);

        $data = $request->only(['name', 'email', 'no_hp']);
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return redirect()->route('admin.management.admin.index')
            ->with('success', "Data admin \"{$admin->name}\" berhasil diperbarui.");
    }

    public function destroy(User $admin)
    {
        if ($admin->id === 1) {
            return redirect()->back()->with('error', 'Admin utama tidak boleh dihapus.');
        }

        if ($admin->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
        }

        $adminName = $admin->name;
        $admin->delete();

        return redirect()->route('admin.management.admin.index')->with('success', "Admin \"$adminName\" berhasil dihapus.");
    }

}
