<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use Illuminate\Http\Request;

class BimbinganDosenController extends Controller
{
    public function index()
    {
        $bimbingans = Bimbingan::with('mahasiswa')
            ->where('dosen_id', auth()->id())
            ->latest()
            ->get();

        return view('dosen.bimbingan.index', compact('bimbingans'));
    }

    public function updateStatus(Request $request, $id)
    {
        $bimbingan = Bimbingan::where('dosen_id', auth()->id())->findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $bimbingan->update(['status' => $request->status]);

        return redirect()->route('dosen.bimbingan.index')->with('success', 'Status bimbingan diperbarui');
    }

    public function addCatatan(Request $request, $id)
    {
        $bimbingan = Bimbingan::where('dosen_id', auth()->id())->findOrFail($id);

        $request->validate([
            'catatan_dosen' => 'required|string'
        ]);

        $bimbingan->update(['catatan_dosen' => $request->catatan_dosen]);

        return redirect()->route('dosen.bimbingan.index')->with('success', 'Catatan berhasil ditambahkan');
    }
}
