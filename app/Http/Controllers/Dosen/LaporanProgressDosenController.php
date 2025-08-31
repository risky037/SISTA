<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\LaporanProgress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LaporanProgressDosenController extends Controller
{
    public function index()
    {
        $laporan = LaporanProgress::with(['mahasiswa', 'proposal'])
            ->whereHas('proposal', function ($q) {
                $q->where('dosen_pembimbing_id', Auth::id());
            })
            ->latest()
            ->get();

        return view('dosen.laporan.index', compact('laporan'));
    }


    public function show($id)
    {
        $laporan = LaporanProgress::with('mahasiswa')->findOrFail($id);
        return view('dosen.laporan.show', compact('laporan'));
    }

    public function update(Request $request, $id)
    {
        $laporan = LaporanProgress::findOrFail($id);

        $request->validate([
            'status' => 'required|in:submitted,reviewed',
            'catatan_dosen' => 'nullable|string'
        ]);

        $laporan->update([
            'status' => $request->status,
            'catatan_dosen' => $request->catatan_dosen,
        ]);

        return redirect()->route('dosen.laporan-progress.index')->with('success', 'Laporan berhasil diperbarui');
    }
}
